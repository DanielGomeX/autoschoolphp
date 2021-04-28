@extends('template.painel-instrutor')
@section('title', 'Serviços Carro')
@section('content')
<?php

use App\Models\instrutore;
use App\Models\veiculo;

@session_start();
if (@$_SESSION['nivel_usuario'] != 'instrutor') {
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

    <a href="{{route('servicos.inserir')}}" type="button" class="mt-4 mb-4 btn btn-primary">Inserir Serviço</a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive table-sm">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Carro</th>
                            <th>Instrutor</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($itens as $item)
                        <?php
                        $data = implode('/', array_reverse(explode('-', $item->dat)));
                        $valor = number_format($item->valor, 2, ',', '.'); 
                        $instrutor = instrutore::where('cpf', '=', $item->instrutor)->first();
                        $instrutor = $instrutor->nome;

                        $veiculo = veiculo::where('id', '=', $item->carro)->first();
                        $marca_carro = @$veiculo->marca;
                        $placa_carro = @$veiculo->placa;

                        ?>
                        <tr>
                            <td><i class="fas fa-check mr-1 text-success <?php if($item->pago != 'Sim'){ ?> text-danger <?php } ?>"></i>{{$marca_carro}} - {{$placa_carro}}</td>
                            <td>{{$instrutor}}</td>
                            <td>{{$item->descricao}}</td>
                            <td>{{$valor}}</td>
                            <td>{{$data}}</td>
                            <td>{{$item->status}}</td>
                            <td>
                                <a title="Editar Dados" href="{{route('servicos.edit', $item)}}"><i class="fas fa-edit text-info mr-1"></i></a>
                                <a title="Excluir Dados" href="{{route('servicos.modal', $item)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
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
                <form method="POST" action="{{route('servicos.delete', $id)}}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Excluir</button>
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