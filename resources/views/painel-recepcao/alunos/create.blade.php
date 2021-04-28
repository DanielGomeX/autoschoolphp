@extends('template.painel-recep')
@section('title', 'Inserir Alunos')
@section('content')

<h6 class="mb-4"><i>CADASTRO DE ALUNOS</i></h6><hr>
<form method="POST" action="{{route('alunos.insert')}}">
        @csrf

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" class="form-control" id="" name="nome" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="" name="email">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone">
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label for="exampleInputEmail1">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco">
                </div>
            </div>
        </div>
        <div class="row">

        <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Categoria</label>
                    <select class="form-control" name="categoria" id="categoria">
                    
                    <?php
                        use App\Models\categoria;
                        $tabela = categoria::all();
                    ?>
                    
                    @foreach($tabela as $item)
                    <option value='{{$item->nome}}' >{{$item->nome}}</option>
                    @endforeach 
                    
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Status Pauta</label>
                    <select class="form-control" name="status_pauta">
                    <option value='Agendamento Detran' >Agendamento DETRAN</option>
                    <option value='Exame Aptidão' >Exame Aptidão</option>
                    <option value='Aulas Legislação' >Aulas Legislação</option>
                    <option value='Prova Legislação' >Provas Legislação</option>
                    <option value='Aulas Direção' >Aulas Direção</option>
                    <option value='Exame Direção' >Exame Direção</option>
                    <option value='Pauta Vencida' >Pauta Vencida</option>
                    <option value='Habilitado' >Habilitado</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Abertura Pauta</label>
                    <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control" id="data" name="data">
                </div>
            </div>

        </div>


    
        <p align="right">
        <button type="submit" class="btn btn-primary">Salvar</button>
        </p>
    </form>


@endsection