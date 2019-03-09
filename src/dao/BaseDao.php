<?php

namespace App\Dao;
use PDO;
class BaseDao 
{
    
    protected $db;
    public function __construct()
    {  
        $this->db = new PDO('mysql:host=localhost;dbname=lep5;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
       
    }    
}


