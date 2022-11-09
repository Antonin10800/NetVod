<?php

namespace netvod\action;


use netvod\Auth\Auth;

class SeConnecter implements Action
{
    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= '<form method="post" action="?action=connexion">';
            $html .= '<input type="email" name="email"  placeholder="Email">';
            $html .= '<input type="password" name="password"  placeholder="Mot de passe">';
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