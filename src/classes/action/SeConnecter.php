<?php

namespace netvod\action;


use netvod\Auth\Auth;

class SeConnecter implements Action
{
    public function execute(): string
    {

        $html = '<!DOCTYPE html>';
        $html .= '<html lang="fr"> <head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<title>Inscription</title>';
        $html .= '<link rel="stylesheet" href="src/css/connexion.css">';
        $html .= '</head><body background="src/classes/images/css/netfix_background.jpeg">';

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= '<form method="post" action="?action=connexion">';
            $html .=  '<div class="title"><h1>Inscription</h1></div>';
            $html .=    '<p>email</p>';
            $html .= '<input type="email" name="email">';
            $html .= '<p>passeword</p>';
            $html .= '<input type="password" name="password" >';
            $html .= '<p>Vous ne possèdez pas de comptre <a id="createCompte" href="?action=inscription">Créer un compte</a></p>';
            $html .= '<button type="submit">Connexion</button>';
            $html .= '</form>';

        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $pass = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $user = Auth::authentificate($email,$pass);
            if($user != null)
            {
                $_SESSION['user'] = ($user);
            }
        }

        return $html;
    }
}