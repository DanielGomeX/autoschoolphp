<?php

namespace App\Http\Controllers;

use App\Models\aluno;
use App\Models\categoria;
use App\Models\conta_receber;
use App\Models\contas_receber;
use App\Models\marcacoe;
use Illuminate\Http\Request;

@session_start();

class MarcacaoRecepController extends Controller
{
    public function index()
    {
        $tabela = marcacoe::orderby('id', 'desc')->get();
        return view('painel-recepcao.marcacoes.index', ['itens' => $tabela]);
    }



    public function create($hora, $data, $instrutor)
    {
        return view('painel-recepcao.marcacoes.create', ['hora' => $hora, 'dat' => $data, 'instrutor' => $instrutor]);
    }


    public function insert(Request $request)
    {      

        $tabela = new marcacoe();
        
        $tabela->aluno = $request->aluno;
        $tabela->hora = $request->hora;
        $tabela->instrutor = $request->instrutor;
        $tabela->dat = $request->dat;
        $tabela->categoria = $request->categoria;
        
        $itens = marcacoe::where('hora', '=', $request->hora)->where('dat', '=', $request->dat)->where('instrutor', '=', $request->instrutor)->count();
        if($itens > 0){
            echo "<script language='javascript'> window.alert('Horário Indisponível!') </script>";
            $tab = marcacoe::orderby('id', 'desc')->paginate();
            return view('painel-recepcao.marcacoes.index', ['itens' => $tab]);
                
        }


        $itens = aluno::where('cpf', '=', $request->aluno)->count();
        
        if($itens == 0){
            echo "<script language='javascript'> window.alert('Aluno sem Cadastro, provavelmente o CPF está Incorreto!') </script>";
            $tab = marcacoe::orderby('id', 'desc')->paginate();
            return view('painel-recepcao.marcacoes.index', ['itens' => $tab]);
                
        }

        $tabela->save();

        $conta = new contas_receber();
        $alunos = aluno::where('cpf', '=', $request->aluno)->first();
        $cat = categoria::where('nome', '=', $request->categoria)->first();

        $valor2 = str_replace(',', '.', $cat->valor);
        $conta->descricao = 'Aula - '. @$_SESSION['nome_usuario'];
        $conta->valor = $valor2;
        $conta->aluno = $alunos->id;
        $conta->recep = $request->instrutor;
        $conta->pago = 'Não';
        $conta->dat = date('Y-m-d');
        $conta->aula = 'Sim';
        $conta->id_marcacao = $tabela->id;
        
        $conta->save();
        $tabela2 = marcacoe::orderby('id', 'desc')->get();
        return view('painel-recepcao.marcacoes.index', ['itens' => $tabela2, 'dat' => $request->data, 'instrutor' => $request->instrutor] );
    }




    public function delete(marcacoe $item, $data, $instrutor)
    {
        $item->delete();
        $conta = contas_receber::where('id_marcacao', '=', $item->id)->first();
        $conta->delete();
        
        $item2 = marcacoe::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.marcacoes.index', ['itens' => $item2, 'dat' => $data, 'instrutor' => $instrutor]);
    }

    public function modal($id, $data, $instrutor)
    {
        $item = marcacoe::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.marcacoes.index', ['itens' => $item, 'id' => $id, 'dat' => $data, 'instrutor' => $instrutor]);
    }



    public function buscar(Request $request)
    {      

        $tabela = marcacoe::orderby('id', 'desc')->get();
        return view('painel-recepcao.marcacoes.index', ['itens' => $tabela, 'dat' => $request->data, 'instrutor' => $request->instrutor] );
    }



}