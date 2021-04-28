@extends('template.painel-instrutor')
@section('title', 'Editar Serviço')
@section('content')

<h6 class="mb-4"><i>EDIÇÃO DE SERVIÇOS</i></h6>
<hr>
<form method="POST" action="{{route('servicos.editar', $item)}}">
    @csrf
    @method('put')

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Placa</label>
                <select class="form-control" name="carro" id="">

                    <?php

                    use App\Models\instrutore;
                    use App\Models\veiculo;

                    @session_start();
                    $cpf_usuario = $_SESSION['cpf_usuario'];
                    $instrutor_id = instrutore::where('cpf', '=', $cpf_usuario)->first();
                    $instrutor_id = $instrutor_id->id;

                    $tabela = veiculo::where('instrutor', '=', $instrutor_id)->get();
                    ?>

                    @foreach($tabela as $val)
                    <option value='{{$val->id}}' <?php if($item->carro == $val->id){ ?> selected <?php } ?>>{{$val->placa}} - {{$val->marca}}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Descrição</label>
                <input value="{{$item->descricao}}" type="text" class="form-control" id="" name="descricao" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input value="{{$item->valor}}" type="text" class="form-control" id="" name="valor" disabled >
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Status</label>
                <select class="form-control" name="status" id="">
                    <option value='Aguardando PGTO' <?php if($item->status == 'Aguardando PGTO'){ ?> selected <?php } ?>>Aguardando PGTO</option>
                    <option value='Pago' <?php if($item->status == 'Pago'){ ?> selected <?php } ?>>Pago</option>
                    <option value='Oficina' <?php if($item->status == 'Oficina'){ ?> selected <?php } ?>>Oficina</option>
                    <option value='Concluído' <?php if($item->status == 'Concluído'){ ?> selected <?php } ?>>Concluído</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mb-3 mt-4">Salvar</button>

    </div>


</form>
@endsection