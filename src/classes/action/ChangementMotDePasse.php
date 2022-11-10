<?php


namespace netvod\action;

use netvod\Auth\Auth;

/**
 * class ChangementMotDePasse
 * permet de changer le mot de passe de l'utilisateur
 */
class ChangementMotDePasse implements Action {

    /**
     * methode execute qui permet de changer le mot de passe de l'utilisateur
     * @return string le html de la page de changement de mot de passe
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

        // token de sécurité
        $token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);

        // si la méthode est GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // formulaire pour changer le mot de passe
            $html .= <<<END
                <form method="post" action="?action=changementMotDePasse&token=$token">
                <div class="title"><h1>Mot de passe oublié</h1></div>
                <p>Password :</p>
                <input type="password" name="password" >
                <p>Password :</p>
                <input type="password" name="password2" >
                <button type="submit">Changer de mot de passe</button>
                </form>
                END;
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            // nettoyage des données
            $mdp1 = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $mdp2 = filter_var($_POST['password2'],FILTER_SANITIZE_STRING);

            //permet de gerer les erreurs de saisie
            if(empty($mdp1) || empty($mdp2) || $mdp1 != $mdp2 || $mdp1 < 10){
                $html .= <<<END
                    <form method="post" action="?action=changementMotDePasse&token=$token">
                    <div class="title"><h1>Mot de passe oublié</h1></div>
                    <p>Password :</p>
                    <input type="password" name="password" >
                    <p>Password :</p>
                    <input type="password" name="password2" >
                    END;

                if(empty($mdp1) || empty($mdp2)) {
                    $html .= "<div class=\"error\" ><p > Veuillez remplir tous les champs !</p ></div >";
                }elseif($mdp1 != $mdp2){
                    $html .= "<div class=\"error\" ><p > Mot de passe différent !</p ></div >";
                }elseif($mdp1 < 10){
                    $html .= "<div class=\"error\" ><p > Mot de passe trop court !</p ></div >";
                }

                $html .= <<<END
                    <button type="submit">Changer de mot de passe</button>
                    </form>
                    END;
            }else{
                // si les données sont correctes on change le mot de passe et on retourne a la page de connexion
                Auth::changerMotDePasse($mdp1, $token);
                header("Location: ?action=connexion");
            }
        }

        return $html;
    }
}