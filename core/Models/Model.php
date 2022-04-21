<?php
namespace Core\Models;

use DB\DBConnection;

class Model 
{

    protected $db;
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
        $this->db = new DBConnection();
    }
    
    public function all()
    {
        
        $req = $this->db->getPDO()->query("SELECT * FROM {$this->table} ORDER BY created_at DESC ");          
        return $req->fetchAll();
    }

    public function findById(int $id)
    {
        
        $req = $this->db->getPDO()->prepare("SELECT * FROM {$this->table} WHERE id=? "); 
        $req->execute([$id]);        
        return $req->fetchAll();
    }

    public function destroy(int $id)
    {

        $req = $this->db->getPDO()->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $req->execute([$id]);
        return $req;
    }

    public function update(int $id, array $data)
    {

        $data["id"] = $id;
    
        $req = $this->db->getPDO()->prepare(" UPDATE {$this->table} SET title = :title,content = :content WHERE id = :id ");
        $req->execute($data);
        return $req;
    }

    public function getByEmail($email)
    {
        $req = $this->db->getPDO()->prepare("SELECT * FROM {$this->table} WHERE email =? "); 
        $req->execute([$email]);        
        return $req->fetchAll();
        

    }

}