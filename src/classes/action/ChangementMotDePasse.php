<?php


namespace netvod\action;

use netvod\Auth\Auth;

class ChangementMotDePasse implements Action
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

        $token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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
            $mdp1 = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $mdp2 = filter_var($_POST['password2'],FILTER_SANITIZE_STRING);
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
                Auth::changerMotDePasse($mdp1, $token);
                header("Location: ?action=connexion");
            }
        }

        return $html;
    }
}