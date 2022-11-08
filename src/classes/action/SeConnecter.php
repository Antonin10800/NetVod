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
            $user = Auth::authentificate($_POST['email'], $_POST['password']);
            if($user != null){
                $_SESSION['utilisateur'] = serialize($user);
                $html = "connecte";
            }else{
                $html = "non connecte";
            }
        }

        return $html;
    }
}