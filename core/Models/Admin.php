<?php
namespace Core\Models;

class Admin extends Model 
{
    protected $table = "admin";
    public function __construct()
    {
        parent::__construct($this->table);
    }

}