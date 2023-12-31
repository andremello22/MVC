<?php 
namespace App\Models;
use MF\Model\Model;

class Tweet extends Model{
    private $id;
    private $id_usuario;
    private $twitter;
    private $data;

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
       $query ='INSERT INTO tweets(id_usuario, tweet)
       VALUES (:id_usuario, :tweet)'; 
       $stmt = $this->db->prepare($query);
       $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
       $stmt->bindValue(':tweet', $this->__get('tweet'));
       $stmt->execute();
       return $this;
       
    }
    //recuperar
    public function getAll(){
        $query = "SELECT 
        t.id, 
        t.id_usuario,
        u.nome, 
        t.tweet, 
        DATE_FORMAT(t.data, '%d/%m/%y %H:%i') as data
        from 
        tweets as t
        left join usuarios as u on (t.id_usuario = u.id)
        where t.id_usuario = :id_usuario or
        t.id_usuario in (select id_usuario_seguindo
        from usuarios_seguidores 
        where id_usuario = :id_usuario)
        order by t.data desc";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    //recuperar com paginação
    public function getPorPagina($limit, $offset){
        $query = "SELECT 
        t.id, 
        t.id_usuario,
        u.nome, 
        t.tweet, 
        DATE_FORMAT(t.data, '%d/%m/%y %H:%i') as data
        from 
        tweets as t
        left join usuarios as u on (t.id_usuario = u.id)
        where t.id_usuario = :id_usuario or
        t.id_usuario in (select id_usuario_seguindo
        from usuarios_seguidores 
        where id_usuario = :id_usuario)
        order by t.data desc
        limit
            $limit
        offset
            $offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getTotalRegistro(){
        $query = "SELECT count(*) as total
        from 
        tweets as t
        left join usuarios as u on (t.id_usuario = u.id)
        where t.id_usuario = :id_usuario or
        t.id_usuario in (select id_usuario_seguindo
        from usuarios_seguidores 
        where id_usuario = :id_usuario)
       "
       ;

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function excluirTweet(){
       $query = "delete from tweets
        where id = :id_tweet ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_tweet',$this->__get('id'));
        $stmt->execute();
        return true;
    
      }
}
?>