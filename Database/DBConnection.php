<?php
namespace DB;

use PDO;

class DBConnection
{
    private $dbname = "Blog";
    private $host ="localhost";
    private $username = "root";
    private $password = "";
    private $pdo;

    public function __construct()
    {
       
    }

    public function getPDO():PDO 
    {
        return $this->pdo ?? $this->pdo = new PDO("mysql:dbname={$this->dbname};host={$this->host}",
        $this->username,$this->password,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        
    }
}

