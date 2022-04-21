<?php

namespace Core\Models;


class Post extends Model
{
    protected $table = "posts";

    public function __construct()
    {
        parent::__construct($this->table);
    }
}