<?php

namespace netvod\action;

use netvod\Auth\Auth;

class MotDePasseOublie implements Action
{
    public function execute(): string
    {

        $html = <<<END
            <!DOCTYPE html>
            <html lang="fr"> <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inscription</title>
            <link rel="stylesheet" href="src/css/connexion.css">
            </head><body background="src/classes/images/css/netfix_background.jpeg">
            END;

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= <<<END
                <form method="post" action="?action=motDePasseOublie">
                <div class="title"><h1>Mot de passe oublié</h1></div>
                <p>Email :</p>
                <input type="email" name="email">
                <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                <button type="submit">Changer de mot de passe</button>
                </form>
                END;

        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            if(empty($_POST['email'])) {
                $html .= <<<END
                    <form method="post" action="?action=motDePasseOublie">
                    <div class="title"><h1>Mot de passe oublié</h1></div>
                    <p>Email :</p>
                    <input type="email" name="email">
                    <div class="error"><p>Veuillez remplir tous les champs !</p></div>
                    <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                    <button type="submit">Changer de mot de passe</button>
                    </form>
                    END;
            }else{
                $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                $possedeCompte = Auth::possedeCompte($email);
                if(!$possedeCompte){
                    $html .= <<<END
                        <form method="post" action="?action=motDePasseOublie">
                        <div class="title"><h1>Mot de passe oublié</h1></div>
                        <p>Email :</p>
                        <input type="email" name="email">
                        <div class="error"><p>Aucun compte ne contient cet email !</p></div>
                        <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                        <button type="submit">Changer de mot de passe</button>
                        </form>
                        END;
                }else{
                    $token = Auth::genererToken($email);
                    header("Location: ?action=changementMotDePasse&token=$token");
                }
            }
        }

        return $html;
    }
}