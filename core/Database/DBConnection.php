<?php
namespace Core\Database;

use PDO;

/**
 * class DBConnection pour gerer la connection à la base de donnée
 * Creation de l'instance PDO / methode getPDO
 */

class DBConnection
{
    private $dbname = "Blog";
    private $host ="localhost";
    private $username = "root";
    private $password = "";
    private $pdo;

    public function getPDO():PDO 
    {
        return $this->pdo ?? $this->pdo = new PDO("mysql:dbname={$this->dbname};host={$this->host}",
        $this->username,$this->password,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        
    }
}