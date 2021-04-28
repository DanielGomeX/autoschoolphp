<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CadInstrutoresController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecepController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComissoesController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\MarcacaoController;
use App\Http\Controllers\MarcacaoRecepController;
use App\Http\Controllers\MovimentacoesController;
use App\Http\Controllers\PagarController;
use App\Http\Controllers\PainelInstrutorController;
use App\Http\Controllers\PainelRecepController;
use App\Http\Controllers\ReceberController;
use App\Http\Controllers\RelController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');
Route::post('painel', [UsuarioController::class, 'login'])->name('usuarios.login');
Route::post('login/recuperar', [UsuarioController::class, 'recuperar'])->name('login.recuperar');

Route::get('instrutores', [CadInstrutoresController::class, 'index'])->name('instrutores.index');
Route::post('instrutores', [CadInstrutoresController::class, 'insert'])->name('instrutores.insert');
Route::get('instrutores/inserir', [CadInstrutoresController::class, 'create'])->name('instrutores.inserir');
Route::get('instrutores/{item}/edit', [CadInstrutoresController::class, 'edit'])->name('instrutores.edit');
Route::put('instrutores/{item}', [CadInstrutoresController::class, 'editar'])->name('instrutores.editar');
Route::delete('instrutores/{item}', [CadInstrutoresController::class, 'delete'])->name('instrutores.delete');
Route::get('instrutores/{item}/delete', [CadInstrutoresController::class, 'modal'])->name('instrutores.modal');

Route::get('recep', [RecepController::class, 'index'])->name('recep.index');
Route::post('recep', [RecepController::class, 'insert'])->name('recep.insert');
Route::get('recep/inserir', [RecepController::class, 'create'])->name('recep.inserir');
Route::get('recep/{item}/edit', [RecepController::class, 'edit'])->name('recep.edit');
Route::put('recep/{item}', [RecepController::class, 'editar'])->name('recep.editar');
Route::delete('recep/{item}', [RecepController::class, 'delete'])->name('recep.delete');
Route::get('recep/{item}/delete', [RecepController::class, 'modal'])->name('recep.modal');

Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::delete('usuarios/{item}', [UsuarioController::class, 'delete'])->name('usuarios.delete');
Route::get('usuarios/{item}/delete', [UsuarioController::class, 'modal'])->name('usuarios.modal');

Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::post('categorias', [CategoriaController::class, 'insert'])->name('categorias.insert');
Route::get('categorias/inserir', [CategoriaController::class, 'create'])->name('categorias.inserir');
Route::get('categorias/{item}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
Route::put('categorias/{item}', [CategoriaController::class, 'editar'])->name('categorias.editar');
Route::delete('categorias/{item}', [CategoriaController::class, 'delete'])->name('categorias.delete');
Route::get('categorias/{item}/delete', [CategoriaController::class, 'modal'])->name('categorias.modal');

Route::get('veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
Route::post('veiculos', [VeiculoController::class, 'insert'])->name('veiculos.insert');
Route::get('veiculos/inserir', [VeiculoController::class, 'create'])->name('veiculos.inserir');
Route::get('veiculos/{item}/edit', [VeiculoController::class, 'edit'])->name('veiculos.edit');
Route::put('veiculos/{item}', [VeiculoController::class, 'editar'])->name('veiculos.editar');
Route::delete('veiculos/{item}', [VeiculoController::class, 'delete'])->name('veiculos.delete');
Route::get('veiculos/{item}/delete', [VeiculoController::class, 'modal'])->name('veiculos.modal');
Route::get('veiculos/{item}/modal-servicos', [VeiculoController::class, 'modalServicos'])->name('veiculos.modalServicos');


Route::get('home-admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/', [UsuarioController::class, 'logout'])->name('usuarios.logout');
Route::put('admin/{usuario}', [AdminController::class, 'editar'])->name('admin.editar');

Route::get('home-recep', [PainelRecepController::class, 'index'])->name('painel-recep.index');
Route::put('painel-recep/{usuario}', [PainelRecepController::class, 'editar'])->name('painel-recep.editar');

Route::get('alunos', [AlunoController::class, 'index'])->name('alunos.index');
Route::post('alunos', [AlunoController::class, 'insert'])->name('alunos.insert');
Route::get('alunos/inserir', [AlunoController::class, 'create'])->name('alunos.inserir');
Route::get('alunos/{item}/edit', [AlunoController::class, 'edit'])->name('alunos.edit');
Route::put('alunos/{item}', [AlunoController::class, 'editar'])->name('alunos.editar');
Route::delete('alunos/{item}', [AlunoController::class, 'delete'])->name('alunos.delete');
Route::get('alunos/{item}/delete', [AlunoController::class, 'modal'])->name('alunos.modal');
Route::get('alunos/{item}/modal-cobrar', [AlunoController::class, 'modal_cobrar'])->name('alunos.modal-cobrar');
Route::post('alunos-cobrar', [AlunoController::class, 'cobrar'])->name('alunos.cobrar');

Route::get('receber', [ReceberController::class, 'index'])->name('receber.index');
Route::delete('receber/{item}', [ReceberController::class, 'delete'])->name('receber.delete');
Route::get('receber/{item}/delete', [ReceberController::class, 'modal'])->name('receber.modal');
Route::get('receber/{item}/modal-baixa', [ReceberController::class, 'modal_baixa'])->name('receber.modal-baixa');
Route::put('receber-baixa/{item}', [ReceberController::class, 'baixa'])->name('receber.baixa');

Route::get('pagar', [PagarController::class, 'index'])->name('pagar.index');
Route::post('pagar', [PagarController::class, 'insert'])->name('pagar.insert');
Route::get('pagar/inserir', [PagarController::class, 'create'])->name('pagar.inserir');
Route::delete('pagar/{item}', [PagarController::class, 'delete'])->name('pagar.delete');
Route::get('pagar/{item}/delete', [PagarController::class, 'modal'])->name('pagar.modal');
Route::get('pagar/{item}/modal-baixa', [PagarController::class, 'modal_baixa'])->name('pagar.modal-baixa');
Route::put('pagar-baixa/{item}', [PagarController::class, 'baixa'])->name('pagar.baixa');

Route::get('movimentacoes', [MovimentacoesController::class, 'index'])->name('movimentacoes.index');

Route::get('relatorios/movimentacoes', [RelController::class, 'movimentacoes'])->name('rel.movimentacoes');
Route::get('relatorios/comissoes', [RelController::class, 'comissoes'])->name('rel.comissoes');
Route::get('relatorios/servicos', [RelController::class, 'servicos'])->name('rel.servicos');
Route::get('relatorios/aulas', [RelController::class, 'aulas'])->name('rel.aulas');
Route::get('relatorios/pagar', [RelController::class, 'pagar'])->name('rel.pagar');
Route::get('relatorios/receber', [RelController::class, 'receber'])->name('rel.receber');

Route::get('comissoes', [ComissoesController::class, 'index'])->name('comissoes.index');


Route::get('movimentacoes', [MovimentacoesController::class, 'index'])->name('movimentacoes.index');

Route::get('servicos', [ServicoController::class, 'index'])->name('servicos.index');
Route::post('servicos', [ServicoController::class, 'insert'])->name('servicos.insert');
Route::get('servicos/inserir', [ServicoController::class, 'create'])->name('servicos.inserir');
Route::get('servicos/{item}/edit', [ServicoController::class, 'edit'])->name('servicos.edit');
Route::put('servicos/{item}', [ServicoController::class, 'editar'])->name('servicos.editar');
Route::delete('servicos/{item}', [ServicoController::class, 'delete'])->name('servicos.delete');
Route::get('servicos/{item}/delete', [ServicoController::class, 'modal'])->name('servicos.modal');

Route::get('marcacoes', [MarcacaoController::class, 'index'])->name('marcacoes.index');
Route::post('marcacoes', [MarcacaoController::class, 'insert'])->name('marcacoes.insert');
Route::get('marcacoes/inserir/{item}/{item2}', [MarcacaoController::class, 'create'])->name('marcacoes.inserir');
Route::delete('marcacoes/{item}/{item2}', [MarcacaoController::class, 'delete'])->name('marcacoes.delete');
Route::get('marcacoes/{item}/{item2}/delete', [MarcacaoController::class, 'modal'])->name('marcacoes.modal');
Route::post('marcacoes/buscar', [MarcacaoController::class, 'buscar'])->name('marcacoes.buscar');

Route::get('horarios', [HorarioController::class, 'index'])->name('horarios.index');
Route::post('horarios', [HorarioController::class, 'insert'])->name('horarios.insert');
Route::get('horarios/inserir', [HorarioController::class, 'create'])->name('horarios.inserir');
Route::get('horarios/{item}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
Route::put('horarios/{item}', [HorarioController::class, 'editar'])->name('horarios.editar');
Route::delete('horarios/{item}', [HorarioController::class, 'delete'])->name('horarios.delete');
Route::get('horarios/{item}/delete', [HorarioController::class, 'modal'])->name('horarios.modal');



Route::get('home-recep', [PainelRecepController::class, 'index'])->name('painel-recep.index');
Route::put('painel-recep/{usuario}', [PainelRecepController::class, 'editar'])->name('painel-recep.editar');

Route::get('home-instrutor', [PainelInstrutorController::class, 'index'])->name('painel-instrutor.index');
Route::put('painel-instrutor/{usuario}', [PainelInstrutorController::class, 'editar'])->name('painel-instrutor.editar');

Route::get('marcacoes-recep', [MarcacaoRecepController::class, 'index'])->name('marcacoes-recep.index');
Route::post('marcacoes-recep', [MarcacaoRecepController::class, 'insert'])->name('marcacoes-recep.insert');
Route::get('marcacoes-recep/inserir/{item}/{item2}/{item3}', [MarcacaoRecepController::class, 'create'])->name('marcacoes-recep.inserir');
Route::delete('marcacoes-recep/{item}/{item2}/{item3}', [MarcacaoRecepController::class, 'delete'])->name('marcacoes-recep.delete');
Route::get('marcacoes-recep/{item}/{item2}/{item3}/delete', [MarcacaoRecepController::class, 'modal'])->name('marcacoes-recep.modal');
Route::post('marcacoes-recep/buscar', [MarcacaoRecepController::class, 'buscar'])->name('marcacoes-recep.buscar');
