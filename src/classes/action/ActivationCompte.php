<?php

namespace netvod\action;

use netvod\Auth\Auth;

/**
 * class ActivationCompte
 * permet d'activer le compte d'un utilisateur
 */
class ActivationCompte implements Action {

    /**
     * methode execute permet d'avoir un rendu html
     * @return string le rendu html
     */
    public function execute(): string {
        // header de la page html
        $html = <<<END
            <!DOCTYPE html>
            <html lang="fr"> <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion</title>
            <script src="src/js/temps.js"></script>
            <link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>
            <link rel="stylesheet" href="src/css/connexion.css">
            </head><body background="src/images/css/netfix_background.jpeg">
            END;

        // nettoyage du token
        $token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);

        // si la requete est de type GET on affiche le bouton pour activer le token
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= <<<END
                <form class="form" method="post" action="?action=activation&token=$token">
                <button type="submit">Activer le compte</button>
                </form></body></html>
                END;
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            // si c'est de type post on active le compte avec le token
            // et la fonction activerCompte qui verifie si le token est encore  valide avant d'activer le compte
            Auth::activerCompte($token);
            // on redirige vers la page de connexion
            header("Location: ?action=connexion");
        }

        return $html;
    }
}