<?php

namespace Core\Mail\ContactMail;

class MailMessage
{
    public function message($email,$message,$name)
    {
        $template =
        "
        <!Doctype>
        <html>
        <head>
        <title>HTML email</title>
        <style>
            .message{ background : white; color : black; padding: 5px 5px ;}
            .code{color : blue; font-size : 1.0em; }
        </style>
        </head>
        <body>
            <div class='message'>
                 <h1> $name </h1>
                 <p>> $message</p>
                 <p>email : <a href=$email>$email</a></p>

                 
            </div>
            </body>
            </html>

        
        ";

        return $template;
    }

}