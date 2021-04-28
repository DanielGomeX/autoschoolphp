<?php

namespace App\Http\Controllers;

use App\Models\horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(){
        $tabela = horario::orderby('hora', 'asc')->paginate();
        return view('painel-admin.horarios.index', ['itens' => $tabela]);
    }

    public function create(){
        return view('painel-admin.horarios.create');
    }
    public function insert(Request $request){
        $tabela = new horario();
        $tabela->hora = $request->hora;
                
        $itens = horario::where('hora', '=', $request->hora)->count();
        if($itens > 0){
            echo "<script language='javascript'> window.alert('Horário já Cadastrado!') </script>";
            return view('painel-admin.horarios.create');
            
        }
        $tabela->save();
        return redirect()->route('horarios.index');
    }

    public function edit(horario $item){
        return view('painel-admin.horarios.edit', ['item' => $item]);   
    }


    public function editar(Request $request, horario $item){
        $item->hora = $request->hora;
        $old = $request->old;
        if($old != $request->nome){
            $itens = horario::where('hora', '=', $request->hora)->count();
            if($itens > 0){
                echo "<script language='javascript'> window.alert('Horário já Cadastrado!') </script>";
                return view('painel-admin.horarios.edit', ['item' => $item]);   
                
            }
        }
        $item->save();
        return redirect()->route('horarios.index');
    }

    public function delete(horario $item){
        $item->delete();
        return redirect()->route('horarios.index');
    }

    public function modal($id){
        $item = horario::orderby('id', 'desc')->paginate();
        return view('painel-admin.horarios.index', ['itens' => $item, 'id' => $id]);
    }
}