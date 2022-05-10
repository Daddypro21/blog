<?php

namespace Core;

class SessionStart
{
    public function sessionStart($lifetime,$path,$domain,$secure,$httpOlnly)
    {
        session_set_cookie_params($lifetime,$path,$domain,$secure,$httpOlnly);
        session_start();
    }
}