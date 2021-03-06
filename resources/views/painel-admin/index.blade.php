@extends('template.painel-admin')
@section('title', 'Painel Administrativo')
@section('content')
<?php

use App\Models\aluno;
use App\Models\comissoe;
use App\Models\conta_pagar;
use App\Models\instrutore;
use App\Models\movimentacoe;
use App\Models\servico;
use App\Models\veiculo;

@session_start();
if(@$_SESSION['nivel_usuario'] != 'admin'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}

//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$totalContasVencidas = conta_pagar::where('data_venc', '<', $hoje)->where('pago', '!=', 'Sim')->count();
$totalAlunos = aluno::count();
$totalVeiculos = veiculo::count();
$totalInstrutores = instrutore::count();
$totalServicos = servico::where('status', '!=', 'Concluído')->count();
$totalAulas = comissoe::where('dat', '>=', $dataInicioMes)->where('dat', '<=', $hoje)->count();


//TOTALIZAR ENTRADAS e SAÍDAS DO DIA
$entradas = 0;
$saidas = 0;
$saldo = 0;
$data_atual = date('Y-m-d');
$tabela = movimentacoe::where('dat', '=', $hoje)->get();
foreach ($tabela as $tab) {
  if ($tab->tipo == 'Entrada') {
    $entradas = $entradas + $tab->valor;
  } else {
    $saidas = $saidas + $tab->valor;
  }
}
$saldo = $entradas - $saidas;

if($saldo < 0){
  $classe = 'text-danger';
  $classe2 = 'border-left-danger';
}else{
  $classe = 'text-success';
  $classe2 = 'border-left-success';
}

$entradas = number_format($entradas, 2, ',', '.');
$saidas = number_format($saidas, 2, ',', '.');
$saldo = number_format($saldo, 2, ',', '.');


//TOTALIZAR ENTRADAS e SAÍDAS DO MES
$entradasMes = 0;
$saidasMes = 0;
$saldoMes = 0;

$tabela = movimentacoe::where('dat', '>=', $dataInicioMes)->where('dat', '<=', $hoje)->get();
foreach ($tabela as $tab) {
  if ($tab->tipo == 'Entrada') {
    $entradasMes = $entradasMes + $tab->valor;
  } else {
    $saidasMes = $saidasMes + $tab->valor;
  }
}
$saldoMes = $entradasMes - $saidasMes;

if($saldoMes < 0){
  $classeMes = 'text-danger';
  $classe2Mes = 'border-left-danger';
}else{
  $classeMes = 'text-success';
  $classe2Mes = 'border-left-success';
}

$entradasMes = number_format($entradasMes, 2, ',', '.');
$saidasMes = number_format($saidasMes, 2, ',', '.');
$saldoMes = number_format($saldoMes, 2, ',', '.');


?>

<div class="row">
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Alunos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAlunos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
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
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total Instrutores</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalInstrutores ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-secondary"></i>
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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Veículos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo @$totalVeiculos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-taxi fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card {{$classe2}} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold {{$classe}} text-uppercase mb-1">Serviços Pendentes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo @$totalServicos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-code-branch fa-2x {{$classe}}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row">
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Contas Vencidas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalContasVencidas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas do Dia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$entradas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Saídas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saidas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card {{$classe2}} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold {{$classe}} text-uppercase mb-1">Saldo Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saldo ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x {{$classe}}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="row">
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Aulas no Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAulas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-taxi fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas do Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$entradasMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Saídas Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saidasMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card {{$classe2Mes}} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold {{$classeMes}} text-uppercase mb-1">Saldo Total Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saldoMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x {{$classeMes}}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection