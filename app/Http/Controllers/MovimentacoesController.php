<?php

namespace App\Http\Controllers;

use App\Models\movimentacoe;
use App\Models\movimentancoe;
use Illuminate\Http\Request;

class MovimentacoesController extends Controller
{
    public function index(){
        $tabela = movimentacoe::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.movimentacoes.index', ['itens' => $tabela]);
    }
}
