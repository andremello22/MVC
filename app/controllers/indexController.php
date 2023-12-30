<?php

namespace app\controllers;
//recursos mini framework
use mf\controller\Action;
use mf\model\Container;

//models
use app\models\Produto;
use app\models\Info;

class IndexController extends Action {
   

	public function index() {
        
      $produto = Container::getModel('produto');
  
      $produtos = $produto->getProdutos();
      $this->view->dados = $produtos;
		  $this->render("index", "layout1");
	}

	public function sobreNos() {
       
    $info = Container::getModel('info');
    $informacao = $info->getInfo();
    $this->view->dados = $informacao;
	  $this->render("sobreNos", "layout2");
	}

}


?>