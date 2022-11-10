<?php

namespace netvod\action;

use netvod\Auth\Auth;

/**
 * class MotDePasseOublie
 * permet de gérer la page de mot de passe oublié
 */
class MotDePasseOublie implements Action {

    /**
     * methode execute qui permet de gérer la page de mot de passe oublié
     * @return string le html de la page de mot de passe oublié
     */
    public function execute(): string {
        // header de la page
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

        // si la méthode est GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // formulaire pour choisir sur quel compte on veut changer le mot de passe
            $html .= <<<END
                <form method="post" action="?action=motDePasseOublie">
                <div class="title"><h1>Mot de passe oublié</h1></div>
                <p>Email :</p>
                <input type="email" name="email">
                <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                <button type="submit">Changer de mot de passe</button>
                </form>
                END;

        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) { // si la méthode est POST
            // nettoyage des données
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

            // permet de gerer le cas ou l'email n'est pas renseigné
            if(empty($email)) {
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
                // on vérifie que l'email existe dans la base de données
                $possedeCompte = Auth::possedeCompte($email);

                // si l'email n'existe pas dans la base de données on affiche un message d'erreur
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
                    // sinon on genere un token et on lui redirige vers la page de changement de mot de passe
                    $token = Auth::genererToken($email);
                    header("Location: ?action=changementMotDePasse&token=$token");
                }
            }
        }

        return $html;
    }
}