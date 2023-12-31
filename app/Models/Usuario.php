<?php 
namespace App\Models;
use MF\Model\Model;

class Usuario extends Model{

    private $id;
    private $nome;
    private $email;
    private $senha;


    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    //salvar
    public function salvar(){
        $query = "INSERT INTO usuarios(nome, email, senha)
        VALUES(:nome, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha')); //md5()->hash 32 caracteres criptografar senha
        $stmt->execute();

        return $this;
    }   
     //validar se um cadastro pode ser feito
    public function validarCadastro(){
        $valido = true;
        if(strlen($this->__get('nome')) < 3){
            $valido = false;
        }
        if(strlen($this->__get('email')) < 3){
            $valido = false;
        }
        if(strlen($this->__get('senha')) < 3){
            $valido = false;
        }
            return $valido;
    }
   
    public function getUsuarioPorEmail(){
          //recuperar um usuário por email
          $query = 'SELECT nome, email 
          from
           usuarios
           where email = :email';
          $stmt = $this->db->prepare($query);
          $stmt->bindValue(':email', $this->__get('email'));
          $stmt->execute();
          
          return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

  

}
?>