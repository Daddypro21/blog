<?php

namespace Core\Models;

class Member extends Model
{
    protected $table = "members";

    public function __construct()
    {
        parent::__construct($this->table);
    }
}