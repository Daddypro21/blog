<?php

namespace Core\Mail;

class Mail 
{
    public function sendMail($too,$subject,$message,$headers)
    {
        mail($too,$subject,$message,$headers);
        
        return true;
    }
}