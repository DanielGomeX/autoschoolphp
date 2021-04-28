<?php

namespace App\Http\Controllers;

use App\Models\comissoe;
use Illuminate\Http\Request;

class ComissoesController extends Controller
{
    public function index(){
        @session_start();
        $tabela = comissoe::where('funcionario', '=', $_SESSION['cpf_usuario'])->orderby('id', 'desc')->paginate();
        return view('painel-instrutor.comissoes.index', ['itens' => $tabela]);
    }
}
