<?php 
namespace app\models;
use mf\model\Model;



class Produto extends Model{
    
    
    public function getProdutos(){
        $query = "SELECT id, descricao, preco
                    FROM tb_produtos";
        return $this->db->query($query)->fetchAll();
}

}
?>