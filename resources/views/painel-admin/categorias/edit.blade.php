@extends('template.painel-admin')
@section('title', 'Editar Categorias')
@section('content')
<h6 class="mb-4"><i>EDIÇÃO DE CATEGORIAS</i></h6><hr>
<form method="POST" action="{{route('categorias.editar', $item)}}">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input value="{{$item->nome}}" type="text" class="form-control" id="" name="nome" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Valor Aula</label>
                    <input value="{{$item->valor}}" type="text" class="form-control" id="" name="valor" required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Comissão em R$</label>
                    <input type="text" value="{{$item->comissao}}" class="form-control" id="" name="comissao" required>
                </div>
            </div>
        <input value="{{$item->nome}}" type="hidden"  name="old">
        <button type="submit" class="btn btn-primary mt-4 mb-3">Salvar</button>

        </div>
        
    </form>
@endsection