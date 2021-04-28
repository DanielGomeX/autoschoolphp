@extends('template.painel-recep')
@section('title', 'Editar Alunos')
@section('content')
<h6 class="mb-4"><i>EDIÇÃO DE ALUNOS</i></h6><hr>
<form method="POST" action="{{route('alunos.editar', $item)}}">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input value="{{$item->nome}}" type="text" class="form-control" id="" name="nome" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input value="{{$item->email}}" type="email" class="form-control" id="" name="email">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">CPF</label>
                    <input value="{{$item->cpf}}" type="text" class="form-control" id="cpf" name="cpf">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input value="{{$item->telefone}}" type="text" class="form-control" id="telefone" name="telefone">
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label for="exampleInputEmail1">Endereço</label>
                    <input value="{{$item->endereco}}" type="text" class="form-control" id="endereco" name="endereco">
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

        <option value='{{$item->categoria}}' >{{$item->categoria}}</option>
        
        @foreach($tabela as $val)
        <?php if($item->categoria != $val->nome){ ?>
            <option value='{{$val->nome}}' >{{$val->nome}}</option>
        <?php } ?>
        @endforeach 
        
        </select>
    </div>
</div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Status Pauta</label>
            <select class="form-control" name="status_pauta">

            <option value='Agendamento Detran' <?php if($item->status_pauta == 'Agendamento Detran'){ ?> selected <?php } ?>>Agendamento Detran</option>
                        <option value='Exame Aptidão' <?php if($item->status_pauta == 'Exame Aptidão'){ ?> selected <?php } ?>>Exame Aptidão</option>
                        <option value='Aulas Legislação' <?php if($item->status_pauta == 'Aulas Legislação'){ ?> selected <?php } ?>>Aulas Legislação</option>
                        <option value='Prova Legislação'<?php if($item->status_pauta == 'Prova Legislação'){ ?> selected <?php } ?>>Prova Legislação</option>
                        <option value='Aulas Direção' <?php if($item->status_pauta == 'Aulas Direção'){ ?> selected <?php } ?>>Aulas Direção</option>
                        <option value='Exame Direção' <?php if($item->status_pauta == 'Exame Direção'){ ?> selected <?php } ?>>Exame Direção</option>
                        <option value='Pauta Vencida'<?php if($item->status_pauta == 'Pauta Vencida'){ ?> selected <?php } ?>>Pauta Vencida</option>
                        <option value='Habilitado' <?php if($item->status_pauta == 'Habilitado'){ ?> selected <?php } ?>>Habilitado</option>
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

            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Abertura Pauta</label>
                    <input value="{{$item->data_pauta}}" type="date" class="form-control" id="data" name="data">
                </div>
            </div>

        </div>


    
        <p align="right">
        <input value="{{$item->credencial}}" type="hidden"  name="oldcredencial">
        <input value="{{$item->cpf}}" type="hidden"  name="oldcpf">
        <input value="{{$item->email}}" type="hidden"  name="oldemail">
        <button type="submit" class="btn btn-primary">Salvar</button>
        </p>
    </form>
@endsection