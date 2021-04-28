<?php

namespace App\Http\Controllers;

use App\Models\conta_pagar;
use App\Models\servico;
use Illuminate\Http\Request;
@session_start();
class ServicoController extends Controller
{
    public function index(){
        $cpf_usuario = $_SESSION['cpf_usuario'];
        $tabela = servico::where('instrutor', '=', $cpf_usuario)->orderby('id', 'desc')->get();
        return view('painel-instrutor.servicos.index', ['itens' => $tabela]);
    }

    public function create(){
        return view('painel-instrutor.servicos.create');
    }


    public function insert(Request $request){
        $tabela = new servico();
        $valor = str_replace(',','.', $request->valor);
        $tabela->carro = $request->carro;
        $tabela->instrutor = @$_SESSION['cpf_usuario'];
        $tabela->descricao = $request->descricao;
        $tabela->valor = $valor;
        $tabela->dat = date('Y-m-d');
        $tabela->pago = 'Não';
        $tabela->status = 'Aguardando Pagamento';
        $tabela->save();

        $contas = new conta_pagar();
        $contas->descricao = $request->descricao;
        $contas->valor = $valor;
        $contas->recep = @$_SESSION['cpf_usuario'];
        $contas->pago = 'Não';
        $contas->data_venc = date('Y-m-d');
        $contas->dat = date('Y-m-d');
        $contas->servico = $tabela->id;

        $contas->save();
        return redirect()->route('servicos.index');
    }


    public function edit(servico $item){
        return view('painel-instrutor.servicos.edit', ['item' => $item]);   
    }

    public function editar(Request $request, servico $item){

        $valor = str_replace(',','.', $request->valor);
        $item->carro = $request->carro;
        $item->instrutor = @$_SESSION['cpf_usuario'];
        $item->descricao = $request->descricao;
        $item->valor = $valor;
        $item->dat = date('Y-m-d');
        $item->status = $request->status;


        $item->save();
        return redirect()->route('servicos.index');
    }


    public function delete(servico $item){
        $item->delete();
        $pagar = conta_pagar::where('servico', '=', $item->id)->first();
        $pagar->delete();
        return redirect()->route('servicos.index');
        }

    public function modal($id){
        $item = servico::orderby('id', 'desc')->paginate();
        return view('painel-instrutor.servicos.index', ['itens' => $item, 'id' => $id]);
    }


}