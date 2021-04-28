@extends('template.painel-admin')
@section('title', 'Editar Horários')
@section('content')
<h6 class="mb-4"><i>EDIÇÃO DE HORÁRIOS</i></h6><hr>
<form method="POST" action="{{route('horarios.editar', $item)}}">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Hora</label>
                    <input value="{{$item->hora}}" type="time" class="form-control" id="" name="hora" required>
                </div>
            </div>
        <input value="{{$item->hora}}" type="hidden"  name="old">
        <button type="submit" class="btn btn-primary mt-4 mb-3">Salvar</button>
        </div>
    </form>
@endsection