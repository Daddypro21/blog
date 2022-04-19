<?php

namespace App\Models;

use DB\DBConnection;

class Model 
{
   
    protected $db;
    
    public function all()
    {
        $this->db = new DBConnection();
        $req = $this->db->getPDO()->query("SELECT * FROM posts ORDER BY created_at DESC ");          
        return $req->fetchAll();
    }

    public function findById($id)
    {
        $db = new DBConnection();
        $req = $db->getPDO()->prepare("SELECT * FROM posts WHERE id=? "); 
        $req->execute([$id]);        
        return $req->fetchAll();
    }
}