<?php 
//CARREGAR DOMPDF
@include "dompdf2/autoload.inc.php";
@include "config.php";

use App\Models\instrutore;
use App\Models\marcacoe;
use App\Models\veiculo;
use Dompdf\Dompdf;

@session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));


$total_entradas = 0;

//TOTALIZAR ENTRADAS e SAÍDAS
$data_atual = date('Y-m-d');
$tabela = marcacoe::where('dat', '>=', $dataInicial)->where('dat', '<=', $dataFinal)->count();
$total_entradas = $tabela;



$total_entradas = number_format($total_entradas, 2, ',', '.');

$dataInicial = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinal = implode('/', array_reverse(explode('-', $dataFinal)));

//ALIMENTAR OS DADOS NO RELATÓRIO
$body1 = "

<style>

	@page {
		margin: 0px;
        
	}

	.footer {
		position:absolute;
		bottom:0;
		width:100%;
		background-color: #ebebeb;
		padding:10px;
	}

	.cabecalho {    
		background-color: #ebebeb;
		padding:10px;
		margin-bottom:30px;
	}

	.titulo{
        margin:0;
        font-size:23px;
        font-family:Arial, Helvetica, sans-serif;
        
    }

    .subtitulo{
        margin:0;
        font-size:14px;
        font-family:Arial, Helvetica, sans-serif;
    }

    .texto_data{
        margin:0;
        font-size:8px;
        font-family:Arial, Helvetica, sans-serif;
    }

    .datas{
        margin-left:15px;
        font-size:11px;
        font-family:Arial, Helvetica, sans-serif;
        margin-top:5px;
    }

    .titulos{
        margin:10px;
    }
    
    .table{
        padding:15px;
        font-family:Verdana, sans-serif;
        margin-top:20px;
    }

    .texto-tabela{
        font-size:14px;
    }

	.areaTotais{
		border : 0.5px solid #bcbcbc;
		padding: 15px;
		border-radius: 5px;
        margin-right:15px;
        margin-left:15px;
	}

</style>

<div class='cabecalho'>
	
	
        <div class='titulos'>
            <div align='right' class='texto_data'> $data_hoje</div>	
			<h3 class='titulo'><b>$nome_escola</h3>
            <span class='subtitulo'>$endereco</span>
            
		</div>
	

</div>

<div class='container'>
<p align='center' class='titulo'>'Relatório de Aulas'</p>
<div align='center' class='datas'>
De $dataInicial à $dataFinal
</div>
<table class='table' width='100%' border='1' cellspacing='0' cellpadding='3'>
			<tr bgcolor='#f9f9f9' >
				
				<td style='font-size:15px' height='30px'> <b>Instrutor</b> </td>
				<td style='font-size:15px'> <b> Data</b> </td>
				<td style='font-size:15px'> <b> Hora</b> </td>
				<td style='font-size:15px'> <b> Categoria</b> </td>
                
            </tr>";
            ?>
                <?php
                $bodydois = ""; 
                foreach($itens as $item){
                    $data = implode('/', array_reverse(explode('-', $item->dat)));

                    $nome_recep = instrutore::where('cpf', '=', $item->instrutor)->first();
                    $nome_recep = @$nome_recep->nome;

                    $carro = veiculo::where('id', '=', $item->carro)->first();
                    $carro = @$carro->placa . '-' .@$carro->marca;
                    
                    $body2 = "
                    <tr class='texto-tabela'>
                    <td>
                    $nome_recep
                    </td>
                    <td>
                    $data
                    </td>
                    <td>
                    $item->hora
                    </td>
                    <td>
                    $item->categoria
                    </td>
                    </tr>
                    
                    ";
                    $bodydois = $bodydois . $body2;
                }
                ?>
<?php $body3 = "

</table>
</div>



<div class='areaTotais'>

<div align='right'><b>Total de Aulas:</b> <span >$tabela</span></div>       
</div>
";

$conteudo = $body1 .  $bodydois . $body3;
$html = utf8_encode($conteudo);

//INICIALIZAR A CLASSE DO DOMPDF
$pdf = new DOMPDF();

//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html(utf8_decode($html));

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'aulas.pdf',
array("Attachment" => false)
);

?>