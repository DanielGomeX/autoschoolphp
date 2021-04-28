@extends('template.painel-admin')
@section('title', 'Veículos')
@section('content')
<?php

use App\Models\instrutore;
use App\Models\servico;

@session_start();
if(@$_SESSION['nivel_usuario'] != 'admin'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
if(!isset($id)){
  $id = ""; 
  
}

if(!isset($id2)){
  $id2 = 0; 
  
}

?>


<a href="{{route('veiculos.inserir')}}" type="button" class="mt-4 mb-4 btn btn-primary">Inserir Veículo</a>

<!-- DataTales Example -->
<div class="card shadow mb-4">

<div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Placa</th>
          <th>Categoria</th>
          <th>KM</th>
          <th>Cor</th>
          <th>Marca</th>
          <th>Ano</th>
          <th>Instrutor</th>
          <th>Revisão</th>
             
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
      @foreach($itens as $item)
      <?php 
       $data = implode('/', array_reverse(explode('-', $item->data_revisao)));
       $instrutor = instrutore::where('id', '=', $item->instrutor)->first();
       if($item->instrutor != '0'){
        $instrutor = $instrutor->nome;
       }else{
        $instrutor = 'Nenhum Instrutor';
       }
       
        
       ?>
         <tr>
            <td>{{$item->placa}}</td>
            <td>{{$item->categoria}}</td>
            <td>{{$item->km}}</td>
            <td>{{$item->cor}}</td>
            <td>{{$item->marca}}</td>
            
            <td>{{$item->ano}}</td>
            <td>{{$instrutor}}</td>
            <td>{{$data}}</td>
                      
            <td>
            <a href="{{route('veiculos.modalServicos', $item)}}"><i class="fas fa-taxi text-success mr-1"></i></a>
            <a href="{{route('veiculos.edit', $item)}}"><i class="fas fa-edit text-info mr-1"></i></a>
            <a href="{{route('veiculos.modal', $item)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
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
  $(document).ready(function () {
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
        <form method="POST" action="{{route('veiculos.delete', $id)}}">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Serviços Efetuados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
     
            <div class="mt-2">
            <?php
                      
                      $tabela = servico::where('carro', '=', $id2)->orderby('id','desc')->get();
                    ?>
                    
                    @foreach($tabela as $item)
                    <?php 
                    $valor = number_format($item->valor, 2, ',', '.'); 
                    $data = implode('/', array_reverse(explode('-', $item->dat)));

                    $instrutor = instrutore::where('cpf', '=', $item->instrutor)->first();
                    $instrutor = @$instrutor->nome;

                    ?>
                    <small><span><i class="fas fa-check mr-1 text-success <?php if($item->pago != 'Sim'){ ?> text-danger <?php } ?>"></i>{{$item->descricao}} R$ {{$valor}} - {{$data}} - Responsável {{$instrutor}}</span></small><hr>
                    @endforeach 
             
            </div>
       
      </div>
     
    </div>
  </div>
</div>

<?php 
if(@$id != ""){
  echo "<script>$('#exampleModal').modal('show');</script>";
}

if(@$id2 != ""){
  echo "<script>$('#exampleModal2').modal('show');</script>";
}
?>

@endsection


