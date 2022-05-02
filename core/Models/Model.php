<?php
namespace Core\Models;

use Core\Database\DBConnection;
use Core\SuperGlobals;

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

    public function postAdminRelation()
    {
        $req = $this->db->getPDO()->query("SELECT p.id id_post,p.title title_post,p.content content_post,p.chapo chapo_post,
        p.created_at created_at_post,p.update_at update_at_post,a.first_name firstname_admin,a.last_name lastname_admin FROM {$this->table}
        p INNER JOIN admin a ON p.id_admin = a.id ORDER BY p.created_at DESC");
        return $req->fetchAll();
    }

    public function findByIdRelationPostAdmin(int $id)
    {
        
        $req = $this->db->getPDO()->prepare("SELECT p.id id_post,p.title title_post,p.content content_post,p.chapo chapo_post,
        p.created_at created_at_post,p.update_at update_at_post,a.first_name firstname_admin,a.last_name lastname_admin FROM {$this->table}
        p INNER JOIN admin a ON p.id_admin = a.id WHERE p.id = ?"); 
        $req->execute([$id]);        
        return $req->fetchAll();
    }

    public function findById(int $id)
    {
        $req = $this->db->getPDO()->prepare("SELECT * FROM {$this->table} WHERE id = ?");
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
        $data['id_admin'] = SuperGlobals::fromSession('id');
        $date = date("Y/m/d H:i:s");
        $data['update_at'] = $date ;
        $req = $this->db->getPDO()->prepare(" UPDATE {$this->table} SET title = :title,content = :content,update_at = :update_at,chapo = :chapo,id_admin = :id_admin WHERE id = :id ");
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
        $data = $req->fetchAll(); 
        return $data;
    }

    public function addConfirmCode(array $data)
    {
        $req = $this->db->getPDO()->prepare(" UPDATE {$this->table} SET confirm_member = :confirm_member WHERE cle = :cle ");
        $response = $req->execute($data);
        return $response; 
    }
    public function createPost($idAdmin, array $data)
    {
        
        $req = $this->db->getPDO()->prepare("INSERT INTO {$this->table} (title,content,chapo,id_admin,created_at)VALUES(?,?,?,?,NOW())");
        $req->execute([$data['title'],$data['content'],$data['chapo'],$idAdmin,]);
        return $req;
    }

    public function comment(array $data)
    {
        
        $req = $this->db->getPDO()->prepare("INSERT INTO {$this->table} (comment,id_members,id_post,date_comment)VALUES(?,?,?,NOW())");
        $response = $req->execute([$data['comment'], $data['id_members'],$data['id_post']  
        ]);
        return $response;

    }

    public function getComment($id)
    {
        $req = $this->db->getPDO()->prepare("SELECT c.id id_comments,c.comment comment_comments,c.date_comment date_comment_comments,
        m.first_name firstname_members, m.last_name lastname_members  FROM {$this->table}
        c INNER JOIN members m ON c.id_members = m.id WHERE c.id_post = ?"); 
        $req->execute([$id]);        
        return $req->fetchAll();

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