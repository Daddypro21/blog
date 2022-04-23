<?php

namespace Core\Mail;

class MailMessage
{
    public function message($url,$codeConfirmation,$name)
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
                 <h1>Bonjour $name </h1>
                 <p>Voici votre code de confirmation :<span class='code'> $codeConfirmation</span></p>
                 <p>Cliquez ici <a href=$url>Blog</a></p>

                 
            </div>
            </body>
            </html>

        
        ";

        return $template;
    }

}