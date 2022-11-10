<?php

namespace netvod\action;

use netvod\Auth\Auth;

class ActivationCompte implements Action
{
    public function execute(): string
    {

        $html = <<<END
            <!DOCTYPE html>
            <html lang="fr"> <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion</title>
            <link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>
            <link rel="stylesheet" href="src/css/connexion.css">
            </head><body background="src/images/css/netfix_background.jpeg">
            END;

        $token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= <<<END
                <form class="form" method="post" action="?action=activation&token=$token">
                <button type="submit">Activer le compte</button>
                </form></body></html>
                END;
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            Auth::activerCompte($token);
            header("Location: ?action=connexion");
        }

        return $html;
    }
}