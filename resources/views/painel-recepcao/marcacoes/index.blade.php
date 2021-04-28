@extends('template.painel-recep')
@section('title', 'Marcar Aula')
@section('content')
<?php

use App\Models\horario;
use App\Models\instrutore;
use App\Models\marcacoe;
use App\Models\veiculo;

@session_start();
if (@$_SESSION['nivel_usuario'] != 'recep') {
  echo "<script language='javascript'> window.location='./' </script>";
}
if (!isset($id)) {
  $id = "";
}

if (!isset($id2)) {
  $id2 = "";
}

if(!isset($instrutor)){
  $instrutor = "";
}

?>



<!-- DataTales Example -->
<?php
if (!isset($data)) {
  $hoje = date('Y-m-d');
} else {
  $hoje = $data;
}

?>

<div class="card-body col-lg-4 col-md-8 col-sm-12" style="background:white">
  <form class="mb-4" method="POST" action="{{route('marcacoes-recep.buscar')}}">
    @csrf
    <div class="row">
    <div class="form-group col-md-12">
      <select class="form-control" name="instrutor">
        <?php
        $tabela2 = instrutore::all();
        ?>
        <option value=''>Selecione um Instrutor</option>
        @foreach($tabela2 as $item2)
        <option value='{{$item2->cpf}}' <?php if($item2->cpf == $instrutor){ ?> selected <?php } ?>>{{$item2->nome}}</option>
        @endforeach

      </select>
    </div>
    </div>
    <div class="row">
      <div class="col-md-8 mb-2">
        <input value="{{$hoje}}" class="form-control" name="data" type="date">

      </div>
      <div class="col-md-4">
        <button class="btn btn-outline-info" type="submit">Buscar</button>

      </div>
    </div>
  </form>
  <?php
  if($instrutor != ""){
  $tabela = horario::orderby('hora', 'asc')->get();
  ?>
  @foreach($tabela as $item)
  <?php
  
  $marcacao = marcacoe::where('instrutor', '=', $instrutor)->where('dat', '=', $hoje)->where('hora', '=', $item->hora)->first();
  if (!isset($marcacao->id)) {
  ?>
    <a href="{{route('marcacoes-recep.inserir', [$item->hora, $hoje, $instrutor])}}" class="btn btn-success mb-2 mr-2">{{$item->hora}}</a>
  <?php } else { ?>
    <a href="{{route('marcacoes-recep.modal', [$marcacao->id, $hoje, $instrutor])}}" class="btn btn-danger mb-2 mr-2">{{$item->hora}}</a>
  <?php } ?>
  @endforeach
  <?php } ?>
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
        <h5 class="modal-title" id="exampleModalLabel">Cancelar Marcação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja Realmente Cancelar este horário?

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{route('marcacoes-recep.delete', [$id, $hoje, $instrutor])}}">
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


?>

@endsection