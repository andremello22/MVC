<?php 
namespace app;
use PDO;
use PDOException;


class Connection{

    public static function getDb(){
        try{       
            $conn = new PDO(
                "mysql:host=localhost;dbname=MVC;charset=utf8",
                "root",
                ""
            );
        }catch(PDOException $e){
            echo'Falha na conexão com o banco!! erro: '.$e;
        } 
        return $conn;
    }

}

?>