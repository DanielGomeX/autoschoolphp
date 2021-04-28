@extends('template.painel-recep')
@section('title', 'Alunos')
@section('content')
<?php
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
<div class="container">

    <a href="{{route('alunos.inserir')}}" type="button" class="mt-4 mb-4 btn btn-primary">Inserir Aluno</a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive table-sm">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Status Pauta</th>
                            <th>Inicio Pauta</th>
                            <th>Cat</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($itens as $item)
                        <?php
                        $data = implode('/', array_reverse(explode('-', $item->data_pauta)));
                        ?>
                        <tr>
                            <td>{{$item->nome}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->cpf}}</td>
                            <td>{{$item->telefone}}</td>
                            <td>{{$item->status_pauta}}</td>
                            <td>{{$data}}</td>
                            <td>{{$item->categoria}}</td>
                            <td>
                                <a title="Gerar Cobrança" href="{{route('alunos.modal-cobrar', $item)}}"><i class="fas fa-coins text-sucess mr-1"></i></a>
                                <a title="Editar Dados" href="{{route('alunos.edit', $item)}}"><i class="fas fa-edit text-info mr-1"></i></a>
                                <a title="Excluir Dados" href="{{route('alunos.modal', $item)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                <form method="POST" action="{{route('alunos.delete', $id)}}">
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
        <h5 class="modal-title" id="exampleModalLabel">Efetuar Cobrança</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <form method="POST" action="{{route('alunos.cobrar')}}">
              @csrf

              <div class="form-group">
                <label for="exampleInputEmail1">Descrição</label>
                <input type="text" class="form-control" id="" name="descricao" required>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="text" class="form-control"  name="valor" required>
              </div>

              <input value="{{$id2}}" type="hidden" name="id">

              <div align="right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Cobrar</button>
              </div>
            </form>

          </div>

          <div class="col-md-6">
            <span class="">Cobranças</span><br>
            <div class="mt-2">
            <?php
                        use App\Models\contas_receber;
                        $tabela = contas_receber::where('aluno','=', $id2)->orderby('id', 'desc')->get();
                    ?>
                    
                    @foreach($tabela as $item)
                    <?php 
                    $valor = number_format($item->valor, 2, ',', '.'); 
                    $data = implode('/', array_reverse(explode('-', $item->dat)));
                    ?>
                    <small><span><i class="fas fa-check mr-1 text-success <?php if($item->pago != 'Sim'){ ?> text-danger <?php } ?>"></i>{{$item->descricao}} R$ {{$valor}} - {{$data}}</span></small><hr>
                    @endforeach 
             
            </div>
          </div>
        </div>
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