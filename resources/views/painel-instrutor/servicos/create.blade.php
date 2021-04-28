@extends('template.painel-instrutor')
@section('title', 'Inserir Serviço')
@section('content')

<h6 class="mb-4"><i>NOVO SERVIÇO</i></h6><hr>
<form method="POST" action="{{route('servicos.insert')}}">
        @csrf
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
                    
                    @foreach($tabela as $item)
                    <option value='{{$item->id}}' >{{$item->placa}} - {{$item->marca}}</option>
                    @endforeach 
                    
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Descrição</label>
                    <input type="text" class="form-control" id="" name="descricao">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Valor</label>
                    <input type="text" class="form-control" id="" name="valor">
                </div>
            </div>
        </div>
        <p align="right">
        <button type="submit" class="btn btn-primary mb-3 mt-4">Salvar</button>
        </p>
    </form>


@endsection