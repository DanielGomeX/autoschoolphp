<?php

namespace App\Http\Controllers;


use App\Models\aluno;
use App\Models\contas_receber;
use Illuminate\Http\Request;
@session_start();
class AlunoController extends Controller
{
    public function index(){
        $tabela = aluno::orderby('id','desc')->paginate();
        return view('painel-recepcao.alunos.index',['itens' => $tabela]);
    }

    public function create(){
        return view('painel-recepcao.alunos.create');

    }

    public function insert(Request $request){
        $tabela = new aluno();
        $tabela->nome = $request->nome;
        $tabela->email = $request->email;
        $tabela->cpf = $request->cpf;
        $tabela->telefone = $request->telefone;
        $tabela->endereco = $request->endereco;
        $tabela->status_pauta = $request->status_pauta;
        $tabela->data_pauta = $request->data;
        $tabela->categoria = $request->categoria;

        

        $itens = aluno::where('cpf', '=', $request->cpf)->orwhere('email', '=', $request->email)->count();
        if($itens > 0){
            echo "<script language='javascript'> window.alert('Registro Já Cadastrado!') </script>";
            return view('painel-recepcao.alunos.create');
        }

        $tabela->save();
        return redirect()->route('alunos.index');
    
    }

    public function edit(aluno $item){
        return view('painel-recepcao.alunos.edit', ['item' => $item]);   
        }
 
 
    public function editar(Request $request, aluno $item){
    
        $item->nome = $request->nome;
        $item->email = $request->email;
        $item->cpf = $request->cpf;
        $item->telefone = $request->telefone;
        $item->endereco = $request->endereco;
        $item->status_pauta = $request->status_pauta;
        $item->data_pauta = $request->data;
        $item->categoria = $request->categoria;


        $oldcpf = $request->oldcpf;
        $oldemail = $request->oldemail;

        if($oldcpf != $request->cpf){
            $itens = aluno::where('cpf', '=', $request->cpf)->count();
            if($itens > 0){
                echo "<script language='javascript'> window.alert('CPF já Cadastrado!') </script>";
                return view('painel-recepcao.alunos.edit', ['item' => $item]);   
                
            }
        }

        if($oldemail != $request->email){
            $itens = aluno::where('email', '=', $request->email)->count();
            if($itens > 0){
                echo "<script language='javascript'> window.alert('Email já Cadastrado!') </script>";
                return view('painel-recepcao.alunos.edit', ['item' => $item]);   
                
            }
        }
       

        $item->save();
            return redirect()->route('alunos.index');
 
    }

    public function delete(aluno $item){
        $item->delete();
        return redirect()->route('alunos.index');
    }

    public function modal($id){
        $item = aluno::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.alunos.index', ['itens' => $item, 'id' => $id]);

    }

    public function cobrar(Request $request){
        
        $tabela = new contas_receber();
        $valor = str_replace(',', '.', $request->valor);
        $tabela->descricao = $request->descricao;
        $tabela->valor = $valor;
        $tabela->aluno = $request->id;
        $tabela->recep = @$_SESSION['cpf_usuario'];
        $tabela->pago = 'Não';
        $tabela->dat = date('Y-m-d');
        $tabela->save();
        
        return redirect()->route('alunos.index');
     }

     public function modal_cobrar($id){
        $item = aluno::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.alunos.index', ['itens' => $item, 'id2' => $id]);

     }
}
