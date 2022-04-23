<?php
namespace Core\Models;

use Core\Database\DBConnection;

abstract class Model 
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

    public function findByCle($cle)
    {
        $req = $this->db->getPDO()->prepare("SELECT * FROM {$this->table} WHERE cle = ? "); 
        $req->execute([$cle]);        
        return $req->fetchAll(); 
    }

    public function addConfirmCode(array $data)
    {
        $req = $this->db->getPDO()->prepare(" UPDATE {$this->table} SET confirm_member = :confirm_member WHERE cle = :cle ");
        $response = $req->execute($data);
        return $response; 
    }
    public function createPost($idAdmin, array $data)
    {
        
        $req = $this->db->getPDO()->prepare("INSERT INTO {$this->table} (title,content,id_admin,created_at)VALUES(?,?,?,NOW())");
        $req->execute([$data['title'],$data['content'],$idAdmin]);
        return $req;
    }

    public function register(array $data)
    {
        $req = $this->db->getPDO()->prepare("INSERT INTO {$this->table} (first_name,last_name,email,passwords,cle,date_register)VALUES(?,?,?,?,?,NOW())");
        $req->execute([
            
                $data['first_name'],$data['last_name'],$data['email'],$data['password'], $data['cle']           
            ]);
        return $req;
        
    }

}