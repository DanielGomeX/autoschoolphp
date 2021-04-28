<?php

namespace App\Http\Controllers;

use App\Models\comissoe;
use App\Models\conta_pagar;
use App\Models\contas_receber;
use App\Models\marcacoe;
use App\Models\movimentacoe;
use App\Models\servico;
use Illuminate\Http\Request;

@session_start();
class RelController extends Controller
{
    public function movimentacoes(Request $request){
        $data_inicial = $request->dataInicial;
        $data_final = $request->dataFinal;
        $tabela = movimentacoe::where('dat', '>=', $data_inicial)->where('dat', '<=', $data_final)->get();
        return view('painel-recepcao.rel.rel_mov', ['itens' => $tabela, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final]);
    }

    public function comissoes(Request $request){
        $data_inicial = $request->dataInicial;
        $data_final = $request->dataFinal;
        $tabela = comissoe::where('dat', '>=', $data_inicial)->where('dat', '<=', $data_final)->where('funcionario', '=', $_SESSION['cpf_usuario'])->get();
        return view('painel-instrutor.rel.rel_comissao', ['itens' => $tabela, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final]);
    }

    public function servicos(Request $request){
        $data_inicial = $request->dataInicial;
        $data_final = $request->dataFinal;
        $status = '%'.$request->pago;
        $tabela = servico::where('dat', '>=', $data_inicial)->where('dat', '<=', $data_final)->where('pago','LIKE',$status)->get();
        return view('painel-admin.rel.rel_servicos', ['itens' => $tabela, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final,'status' => $request->pago]);
    }

    public function aulas(Request $request){
        $data_inicial = $request->dataInicial;
        $data_final = $request->dataFinal;
        
        $tabela = marcacoe::where('dat', '>=', $data_inicial)->where('dat', '<=', $data_final)->orderby('dat', 'asc')->get();
        return view('painel-admin.rel.rel_aulas', ['itens' => $tabela, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final]);
    }

    public function pagar(Request $request){
        $data_inicial = $request->dataInicial;
        $data_final = $request->dataFinal;
        $status = '%'.$request->pago;
        $tabela = conta_pagar::where('dat', '>=', $data_inicial)->where('dat', '<=', $data_final)->where('pago','LIKE',$status)->get();
        return view('painel-recepcao.rel.rel_pagar', ['itens' => $tabela, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final,'status' => $request->pago]);
    }

    public function receber(Request $request){
        $data_inicial = $request->dataInicial;
        $data_final = $request->dataFinal;
        $status = '%'.$request->pago;
        $tabela = contas_receber::where('dat', '>=', $data_inicial)->where('dat', '<=', $data_final)->where('pago','LIKE',$status)->get();
        return view('painel-recepcao.rel.rel_receber', ['itens' => $tabela, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final,'status' => $request->pago]);
    }
}