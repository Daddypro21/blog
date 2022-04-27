<?php
namespace Core\Models;

class Comment extends Model
{
    protected $table = "comments";
    public function __construct()
    {
        parent::__construct($this->table);
    }
}