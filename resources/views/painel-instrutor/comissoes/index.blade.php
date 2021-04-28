@extends('template.painel-instrutor')
@section('title', 'Comissoes')
@section('content')
<?php

use App\Models\instrutore;
use App\Models\veiculo;

@session_start();
if (@$_SESSION['nivel_usuario'] != 'instrutor') {
    echo "<script language='javascript'> window.location='./' </script>";
}

?>
<div class="container">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive table-sm">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <h2>Comissões</h2>
                        <tr>
                            <th>Valor</th>
                            <th>Data</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($itens as $item)
                        <?php
                        $data = implode('/', array_reverse(explode('-', $item->dat)));
                        $valor = number_format($item->valor, 2, ',', '.'); 

                        ?>
                        <tr>
                            <td>{{$valor}}</td>
                            <td>{{$data}}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>
        @endsection