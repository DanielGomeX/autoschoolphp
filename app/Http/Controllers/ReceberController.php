<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Models\comissoe;
use App\Models\contas_receber;
use App\Models\movimentacoe;
use Illuminate\Http\Request;
@session_start();
class ReceberController extends Controller
{
    public function index(){
        $tabela = contas_receber::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.receber.index', ['itens' => $tabela]);
    }

   

        public function delete(contas_receber $item){
        $item->delete();
        return redirect()->route('receber.index');
     }

     public function modal($id){
        $item = contas_receber::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.receber.index', ['itens' => $item, 'id' => $id]);

     }



     public function baixa(Request $request, contas_receber $item){
         
        $func = $item->recep;
        $item->pago = 'Sim';
        $item->recep = @$_SESSION['cpf_usuario'];
        $item->dat = date('Y-m-d');
        
        $tabela = new movimentacoe();
        $valor = str_replace(',','.', $item->valor);
        $tabela->tipo = 'Entrada';
        $tabela->descricao = $item->descricao;
        $tabela->recep = @$_SESSION['cpf_usuario'];
        $tabela->valor = $valor;
        $tabela->dat = date('Y-m-d');

        if($item->aula == 'Sim'){
        $comissao = new comissoe();
        $cat = categoria::where('valor', '=', $item->valor)->first();
        $valor2 = str_replace(',','.', $cat->comissao);
        $comissao->descricao = 'Aula';
        $comissao->funcionario = $func;
        $comissao->valor = $valor2;
        $comissao->dat = date('Y-m-d');
        $comissao->save();
        }

        $item->save();
        $tabela->save();
        return redirect()->route('receber.index');

     }

     public function modal_baixa($id){
        $item = contas_receber::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.receber.index', ['itens' => $item, 'id2' => $id]);

     }


}