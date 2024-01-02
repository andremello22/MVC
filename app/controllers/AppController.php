<?php

namespace App\Controllers;

//os recursos do miniframework

use App\Models\Usuario;
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {
    public function timeline(){
        session_start();
        if(!(empty($_SESSION['id']) && empty($_SESSION['nome']))){
           $this->render('timeline'); 
           
        }else{
            header('location: /?login=erro');
        }
    }
}
?>