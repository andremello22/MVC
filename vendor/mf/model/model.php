<?php 
namespace mf\model;
use PDO;

abstract class Model{
    protected $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

}

?>