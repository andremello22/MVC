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
            $tweets = $tweet->getAll();
            
            $this->view->tweets = $tweets;

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
        echo '<br /><br /><br /><br /><br />';
       
        $pesquisarPor = isset($_GET['pesquisarPor'])?$_GET['pesquisarPor']:'';
        
     

        $usuario = array();
        if(!empty($pesquisarPor)){
            $usuario = Container::getModel('Usuario');
            $usuario->__set('nome', $pesquisarPor);
            $usuarios = $usuario->getAll();
           
        }
        $this->view->usuarios =   $usuarios;
        
        $this->render('quem_seguir');


    }

}
?>