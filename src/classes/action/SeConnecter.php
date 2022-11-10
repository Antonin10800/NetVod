<?php

namespace netvod\action;


use netvod\Auth\Auth;

class SeConnecter implements Action
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

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= <<<END
                <form method="post" action="?action=connexion">
                <div class="title"><h1>Connexion</h1></div>
                <p>Email :</p>
                <input type="email" name="email">
                <p>Password :</p>
                <input type="password" name="password" >
                <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                <p>Mot de passe oublié <a id="createCompte" href="?action=motDePasseOublie">Besoin d\'aide ?</a></p>
                <button type="submit">Connexion</button>
                </form>
                END;

        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {

            if(empty($_POST['email']) || empty($_POST['password'])) {
                $html .= <<<END
                    <form method="post" action="?action=connexion">
                    <div class="title"><h1>Connexion</h1></div>
                    <p>Email :</p>
                    <input type="email" name="email">
                    <p>Password :</p>
                    <input type="password" name="password" >
                    <div class="error"><p>Veuillez remplir tous les champs !</p></div>
                    <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                    <p>Mot de passe oublié <a id="createCompte" href="?action=motDePasseOublie">Besoin d\'aide ?</a></p>
                    <button id="disable" type="submit">Connexion</button></form>
                    END;
            }else{
                $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                $pass = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
                $user = Auth::authentificate($email,$pass);
                if($user != null && Auth::etreActiverCompte($_POST['email']) == 1)
                {
                    $_SESSION['user'] = serialize($user);
                    header("Location: ?action=lobby");
                    return '';
                }else if($user == null){
                    $html .= <<<END
                        <form method="post" action="?action=connexion">
                        <div class="title"><h1>Connexion</h1></div>
                        <p>Email :</p>
                        <input type="email" name="email">
                        <p>Password :</p>
                        <input type="password" name="password" >
                        <div class="error"><p>Email ou mot de passe incorrect !</p></div>
                        <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                        <p>Mot de passe oublié <a id="createCompte" href="?action=motDePasseOublie">Besoin d\'aide ?</a></p>
                        <button id="disable" type="submit">Connexion</button></form>
                        END;
                }else if(1 != Auth::etreActiverCompte($_POST['email'])){
                    $token = Auth::genererToken($email);

                    $html .= <<<END
                        <form method="post" action="?action=connexion">
                        <div class="title"><h1>Connexion</h1></div>
                        <p>Email :</p>
                        <input type="email" name="email">
                        <p>Password :</p>
                        <input type="password" name="password" >
                        <div class="error"><a href="?action=activation&token=$token">Cliquez ici pour activer votre compte !</a></div>
                        <p>Vous ne possédez pas de compte <a id="createCompte" href="?action=inscription">Créer un compte</a></p>
                        <p>Mot de passe oublié <a id="createCompte" href="?action=motDePasseOublie">Besoin d\'aide ?</a></p>
                        <button id="disable" type="submit">Connexion</button></form>
                        END;
                }
            }
        }

        return $html;
    }
}