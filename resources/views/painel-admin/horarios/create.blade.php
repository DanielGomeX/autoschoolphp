@extends('template.painel-admin')
@section('title', 'Inserir Horários')
@section('content')
<h6 class="mb-4"><i>CADASTRO DE CATEGORIAS</i></h6><hr>
<form method="POST" action="{{route('horarios.insert')}}">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Horário</label>
                    <input type="time" min="7:00" max="19:00" class="form-control" id="" name="hora" required>
                </div>
            </div>
        <button type="submit" class="btn btn-primary mt-4 mb-3">Salvar</button>
        </div>
    </form>
@endsection