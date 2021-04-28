@extends('template.painel-recep')
@section('title', 'Marcar Horário')
@section('content')

<?php

use App\Models\instrutore;

@include "config.php";
$nome_instrutor = instrutore::where('cpf', '=', $instrutor)->first();
$nome_instrutor = @$nome_instrutor->nome;

?>
<h6 class="mb-4"><i>NOVO HORÁRIO - Instrutor {{$nome_instrutor}}</i></h6>
<hr>
<form method="POST" action="{{route('marcacoes-recep.insert')}}">
    @csrf

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">CPF Aluno</label>
                <input type="text" class="form-control" id="cpf" name="aluno">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Categoria</label>
                <select class="form-control" name="categoria" id="categoria">

                    <?php

                    use App\Models\categoria;

                    $tabela = categoria::all();
                    ?>

                    @foreach($tabela as $item)
                    <option value='{{$item->nome}}'>{{$item->nome}}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Data</label>
                <input value="<?php echo $dat ?>" type="date" class="form-control" id="" name="dat" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Hora</label>
                <input value="<?php echo $hora ?>" type="time" class="form-control" id="" name="hora">
            </div>
        </div>

        <input value="<?php echo $instrutor ?>" type="hidden" name="instrutor">
        <button type="submit" class="btn btn-primary mb-3 mt-4">Salvar</button>


    </div>




</form>
@endsection