<?php

namespace App\Http\Controllers;

include 'config.php';
use App\Models\usuario;
use Illuminate\Http\Request;

    class UsuarioController extends Controller
    {
        public function login(Request $request){
            
            $usuario = $request->usuario;
            $senha = $request->senha;
            $usuarios = usuario::where('usuario', '=', $usuario)->orwhere('cpf', '=', $usuario)->where('senha', '=', $senha)->first();
            if(@$usuarios->id != null){
                @session_start();
                $_SESSION['id_usuario'] = $usuarios->id;
                $_SESSION['nome_usuario'] = $usuarios->nome;
                $_SESSION['nivel_usuario'] = $usuarios->nivel;
                $_SESSION['cpf_usuario'] = $usuarios->cpf;
                
                if($_SESSION['nivel_usuario'] == 'admin'){
                    return view('painel-admin.index');
                }
                if($_SESSION['nivel_usuario'] == 'instrutor'){
                    return view('painel-instrutor.index');
                }
                if($_SESSION['nivel_usuario'] == 'recep'){
                    return view('painel-recepcao.index');
                }
            }else{
                echo "<script language='javascript'> window.alert('Dados Incorretos!') </script>";
                return view('index');
            }
            
        }
        public function logout(){
        @session_start();
        @session_destroy();
        return view('index');
        }
        public function index(){
            $tabela = usuario::orderby('id', 'desc')->paginate();
            return view('painel-admin.usuarios.index', ['itens' => $tabela]);
        }
        public function delete(usuario $item){
            $item->delete();
            return redirect()->route('usuarios.index');
        }
        public function modal($id){
            $item = usuario::orderby('id', 'desc')->paginate();
            return view('painel-admin.usuarios.index', ['itens' => $item, 'id' => $id]);
        }

        public function recuperar(request $request){
            $usuario = usuario::where('usuario', '=', $request->email)->first();
            
            if(!isset($usuario->id)){
                echo "<script language='javascript'> window.alert('Email não Cadastrado!') </script>";
            }else{
                //ENVIAR A SENHA PARA O EMAIL
                $to = $usuario->usuario;
                $subject = 'Recuperação de Senha Auto Escola';
    
                $message = "
    
                Olá $usuario->nome!! 
                <br><br> Sua senha é <b>$usuario->senha </b>
                
                ";
    
                $dest = $request->email_adm;
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
                $headers .= "From: " .$dest;
                @mail($to, $subject, $message, $headers);
    
                echo "<script language='javascript'> window.alert('Senha Enviada para o Email') </script>";
    
            }
            return view('index');
        }
    }
