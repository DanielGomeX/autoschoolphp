@extends('template.painel-instrutor')
@section('title', 'Painel Instrutor')
@section('content')
<?php

use App\Models\aluno;
use App\Models\comissoe;
use App\Models\marcacoe;

@session_start();
    if(@$_SESSION['nivel_usuario'] != 'instrutor'){ 
    echo "<script language='javascript'> window.location='./' </script>";
    }
?>
<?php
//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$totalAulasHoje = marcacoe::where('dat', '=', $hoje)->where('instrutor', '=', $_SESSION['cpf_usuario'])->count();
$totalAulasMes = marcacoe::where('dat', '>=', $dataInicioMes)->where('dat', '<=', $hoje)->where('instrutor', '=', $_SESSION['cpf_usuario'])->count();


$totalComissoesHoje = 0;
$tabela = comissoe::where('dat', '=', $hoje)->where('funcionario', '=', $_SESSION['cpf_usuario'])->get();
foreach ($tabela as $tab) {
$totalComissoesHoje = $totalComissoesHoje + $tab->valor;
}
$totalComissoesHoje = number_format($totalComissoesHoje, 2, ',', '.');


$totalComissoesMes = 0;
$tabela = comissoe::where('dat', '>=', $dataInicioMes)->where('dat', '<=', $hoje)->where('funcionario', '=', $_SESSION['cpf_usuario'])->get();
foreach ($tabela as $tab) {
$totalComissoesMes = $totalComissoesMes + $tab->valor;
}
$totalComissoesMes = number_format($totalComissoesMes, 2, ',', '.');

?>

<div class="row">
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Aulas Hoje</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAulasHoje ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Aulas Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAulasMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Comissões Hoje</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$totalComissoesHoje ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Comissões Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$totalComissoesMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="text-xs font-weight-bold text-secondary text-uppercase mt-4">Aulas do Dia</div>
<hr> 

<div class="row">
<?php
  $tabela = marcacoe::where('dat', '=', $hoje)->where('instrutor', '=', $_SESSION['cpf_usuario'])->orderby('hora', 'asc')->get();
  foreach ($tabela as $tab) {
    $nome_aluno = aluno::where('cpf', '=', $tab->aluno)->first();
  ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-danger text-uppercase">{{$nome_aluno->nome}}</div>
                        <div class="text-xs text-secondary">CATEGORIA {{$tab->categoria}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x  text-danger"></i><br>
                        <span class="text-xs">{{$tab->hora}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php } ?>
    
</div>

@endsection