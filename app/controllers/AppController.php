<?php

namespace App\Controllers;

//os recursos do miniframework

use App\Models\Usuario;
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {
    
    public function timeline(){

            $this->validaAutenticacao();
           //recuperar tweets
            $tweet = Container::getModel('tweet');
            $tweet->__set('id_usuario', $_SESSION['id']);
            
            $total_registros_pagina = 10;
            $pagina = isset($_GET['pagina'])?$_GET['pagina']:1;
            $deslocamento = ($pagina - 1)*$total_registros_pagina;
            /*
            $total_registros_pagina = 10;
            $deslocamento = 10;
            $pagina = 2;*/

            //echo "<br><br><br><br>pagina: $pagina | total de registros por pagina: $total_registros_pagina | deslocamento: $deslocamento <br>";
            $tweets = $tweet->getPorPagina( $total_registros_pagina, $deslocamento);
            $total_tweets = $tweet->getTotalRegistro();
            $this->view->total_de_paginas = ceil($total_tweets['total']/$total_registros_pagina);
            $this->view->pagina_ativa = $pagina;
            $this->view->tweets = $tweets;

            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
            $this->view->info_usuario = $usuario->getInfoUsuario();
            $this->view->total_tweets = $usuario->getTotalTweets();
            $this->view->total_seguindo = $usuario->getTotalSeguindo();
            $this->view->total_seguidores  = $usuario->getTotalSeguidores();
            $this->render('timeline'); 
           
       
    }

    public function tweet(){

        $this->validaAutenticacao();
            $tweet = Container::getModel('Tweet');
            $tweet->__set('tweet', $_POST['tweet']);
            $tweet->__set('id_usuario', $_SESSION['id']);
            $tweet->salvar();
            header('location: /timeline');
           
      
       
    }
    public function validaAutenticacao(){
        session_start();
        if(((!isset($_SESSION['id'])) || empty($_SESSION['id'])) || ((!isset($_SESSION['nome'])) || empty($_SESSION['nome']))){
            header('location: /?login=erro');
        }
    }

    public function quemSeguir(){

        $this->validaAutenticacao();
      
        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor']:'';
        
     

        $usuarios = array();
        if(!empty($pesquisarPor)){
            $usuario = Container::getModel('usuario');
            $usuario->__set('nome', $pesquisarPor);
            $usuario->__set('id', $_SESSION['id']);
            $usuarios = $usuario->getAll();
           
        }
        $this->view->usuarios =   $usuarios;
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->total_tweets = $usuario->getTotalTweets();
        $this->view->total_seguindo = $usuario->getTotalSeguindo();
        $this->view->total_seguidores  = $usuario->getTotalSeguidores();
        
        $this->render('quem_seguir');


    }

    public function acao(){
        $this->validaAutenticacao();
       
        //acao
        $acao = isset($_GET['acao'])?$_GET['acao']:'';
        $id_usuario_seguindo = isset($_GET['id_usuario'])?$_GET['id_usuario']:'';

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        if($acao == 'seguir'){
            $usuario->seguirUsuario($id_usuario_seguindo);
        }else if($acao == 'deixar_de_seguir'){
            $usuario->deixarSeguirUsuario($id_usuario_seguindo);
        }
        header('location: /quem_seguir');
    }

    public function excluir(){
        $this->validaAutenticacao();
        $acao = isset($_GET['excluir_tweet'])?($_GET['excluir_tweet']):'';
        
        $usuario = Container::getModel('Tweet');
        $usuario->__set('id', $_GET['excluir_tweet']);
        if(!empty($acao)){
           
            $usuario->excluirTweet();
        }
       header('location: /timeline');
    }
}
?>