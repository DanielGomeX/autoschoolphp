@extends('template.painel-recep')
@section('title', 'Contas a Receber')
@section('content')
<?php

use App\Models\aluno;
use App\Models\instrutore;
use App\Models\movimentacoe;
use App\Models\recepcionista;

@session_start();
if (@$_SESSION['nivel_usuario'] != 'recep') {
    echo "<script language='javascript'> window.location='./' </script>";
}
if (!isset($id)) {
    $id = "";
}

if (!isset($id2)) {
    $id2 = 0;
}

?>

<?php
$total_entradas = 0;
//TOTALIZAR ENTRADAS
$data_atual = date('Y-m-d');
$tabela = movimentacoe::where('dat', '>=', $data_atual)->where('dat', '<=', $data_atual)->get();
foreach ($tabela as $tab) {
  if ($tab->tipo == 'Entrada') {
    $total_entradas = $total_entradas + $tab->valor;
  } 
}

$total_entradas = number_format($total_entradas, 2, ',', '.');

@include "config.php";
?>

<div class="container">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Aluno</th>
                            <th>Recepcionista</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($itens as $item)
                        <?php
                        $data = implode('/', array_reverse(explode('-', $item->dat)));
                        $valor = number_format($item->valor, 2, ',', '.'); 

                        $nome_aluno = aluno::where('id', '=', $item->aluno)->first();
                        $nome_aluno = $nome_aluno->nome;

                        if($item->aula == 'Sim' && $item->pago == 'Não'){
                            $nome_recep = instrutore::where('cpf', '=', $item->recep)->first();
                            $nome_recep = $nome_recep->nome;
                        }else{
                        $nome_recep = recepcionista::where('cpf', '=', $item->recep)->first();
                        $nome_recep = $nome_recep->nome;
                        }
                                                ?>
                        <tr>
                        
                            <td><i class="fas fa-square mr-1 text-success <?php if($item->pago != 'Sim'){ ?> text-danger <?php } ?>"></i>{{$item->descricao}}</td>
                            <td>{{$valor}}</td>
                            <td>{{@$nome_aluno}}</td>
                            <td>{{@$nome_recep}}</td>
                            <td>{{$data}}</td>
                            <td>
                            <?php if($item->pago != 'Sim'){ ?> 
                                <a title="Baixar Pagamento" href="{{route('receber.modal-baixa', $item)}}"><i class="fas fa-coins text-sucess mr-1"></i></a>
                                <a title="Excluir Dados" href="{{route('receber.modal', $item)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            <div class="row ml-2 mb-4 mr-4">
        <div class="col-md-12" align="right">
        <span class="">Entradas do Dia: <span class="text-success">R$ {{$total_entradas}}</span></span>
        </div>
  </div>
    </div>


</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deletar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja Realmente Excluir este Registro?

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{route('receber.delete', $id)}}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cobrar -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Efetuar Baixa de Pagamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                Deseja Realmente dar baixa neste pagamento?<br>
                Após a baixa o status muda de vermelho para verde.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{route('receber.baixa', $id2)}}">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-success">Baixar</button>
                </form>
            </div>
    </div>
  </div>
</div>


        <?php
        if (@$id != "") {
            echo "<script>$('#exampleModal').modal('show');</script>";
        }

        if (@$id2 != "") {
            echo "<script>$('#exampleModal2').modal('show');</script>";
        }
        ?>

        @endsection