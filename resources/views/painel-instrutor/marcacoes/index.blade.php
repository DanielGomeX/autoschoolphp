@extends('template.painel-instrutor')
@section('title', 'Marcar Aula')
@section('content')
<?php

use App\Models\horario;
use App\Models\marcacoe;


@session_start();
if (@$_SESSION['nivel_usuario'] != 'instrutor') {
  echo "<script language='javascript'> window.location='./' </script>";
}
if (!isset($id)) {
  $id = "";
}

if (!isset($id2)) {
  $id2 = "";
}

?>



<!-- DataTales Example -->
<?php
if(!isset($dat)){
  $hoje = date('Y-m-d');
}else{
  $hoje = $dat;
}

?>

  <div class="card-body col-lg-4 col-md-8 col-sm-12" style="background:white">
  <form class="form-inline mb-4" method="POST" action="{{route('marcacoes.buscar')}}">
  @csrf
      <input value="{{$hoje}}" class="col-md-8 form-control mr-sm-2" name="dat" type="date" >
      <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  <?php
        $tabela = horario::orderby('hora', 'asc')->get();
      ?>
       @foreach($tabela as $item)
       <?php
        
        $marcacao = marcacoe::where('instrutor', '=', $_SESSION['cpf_usuario'])->where('dat', '=', $hoje)->where('hora', '=', $item->hora)->first();
        if(!isset($marcacao->id)){
        ?>
            <a href="{{route('marcacoes.inserir', [$item->hora, $hoje])}}" class="btn btn-success mb-2 mr-2">{{$item->hora}}</a>
        <?php }else{ ?>
          <a href="{{route('marcacoes.modal', [$marcacao->id, $hoje])}}" class="btn btn-danger mb-2 mr-2">{{$item->hora}}</a>
        <?php } ?>
      @endforeach 
      
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
        <form method="POST" action="{{route('marcacoes.delete', [$id, $hoje])}}">
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