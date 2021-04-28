@extends('template.painel-recep')
@section('title', 'Movimentações')
@section('content')
<?php

use App\Models\movimentacoe;
use App\Models\recepcionista;

@session_start();
    if(@$_SESSION['nivel_usuario'] != 'recep'){ 
    echo "<script language='javascript'> window.location='./' </script>";
    }
    if(!isset($id)){
    $id = ""; 
    
    }

?>
    <div class="container">


    <?php
    $total_entradas = 0;
    $total_saidas = 0;
    $saldo = 0;

        ///TOTALIZAR ENTRADAS e SAÍDAS
    $data_atual = date('Y-m-d');
    $tabela = movimentacoe::where('dat', '>=', $data_atual)->where('dat', '<=', $data_atual)->get();
    foreach ($tabela as $tab) {
    if ($tab->tipo == 'Entrada') {
        $total_entradas = $total_entradas + $tab->valor;
    } else {
        $total_saidas = $total_saidas + $tab->valor;
    }
    }
    $saldo = $total_entradas - $total_saidas;

    $total_entradas = number_format($total_entradas, 2, ',', '.');
    $total_saidas = number_format($total_saidas, 2, ',', '.');
    $saldo = number_format($saldo, 2, ',', '.');
    ?>
    
    <!-- DataTales Example -->
<div class="card shadow mb-4">

<div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Descrição</th>
          <th>Valor</th>
          <th>Recepcionista</th>
          <th>Data</th>


        </tr>
      </thead>

      <tbody>
    
        @foreach($itens as $item)
        <?php

        $valor = number_format($item->valor, 2, ',', '.');
        $data = implode('/', array_reverse(explode('-', $item->dat)));

        $nome_recep = recepcionista::where('cpf', '=', $item->recep)->first();
        $nome_recep = @$nome_recep->nome;

        ?>
        <tr>
          <td><i class="fas fa-square mr-1 text-success <?php if ($item->tipo != 'Entrada') { ?> text-danger <?php } ?>"></i>{{$item->descricao}}</td>
          <td>R$ {{$valor}}</td>
          <td>{{$nome_recep}}</td>
          <td>{{$data}}</td>
        </tr>
        @endforeach
      </tbody>

    </table>
    </div>
    </div>
    <div class="row ml-2 mb-4 mr-4">
    <div class="col-md-8">
      <span class="">Entradas do Dia: <span class="text-success">R$ {{$total_entradas}}</span></span>
      <span class="ml-4 ">Saídas do Dia: <span class="text-danger">R$ {{$total_saidas}}</span></span>
    </div>
    <div class="col-md-4" align="right">
      <span class="">Saldo do Dia: <span class="text-success <?php if ($saldo < 0) { ?> text-danger <?php } ?>">R$ {{$saldo}}</span></span>
    </div>
    </div>
    </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
        "ordering": false
        })

    });
    </script>

    <?php 
    if(@$id != ""){
    echo "<script>$('#exampleModal').modal('show');</script>";
    }
    ?>

    @endsection


