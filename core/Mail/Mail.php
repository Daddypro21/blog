<?php

namespace Core\Mail;

class Mail 
{
    public function sendMail($to,$subject,$message,$headers)
    {
        mail($to,$subject,$message,$headers);
        
        return true;
    }
}