<?php

namespace netvod\action;

use netvod\auth\Auth;

class Inscription implements Action
{
    public function execute(): string
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="fr"> <head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<title>Inscription</title>';
        $html .= '<link rel="stylesheet" href="src/classes/css/Inscription.css">';
        $html .= '</head><body background="src/classes/images/css/netfix_background.jpeg">';
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= '<form method="post" action="?action=inscription">';
            $html .= '<div class="title"><h1>Inscription</h1></div>';
            $html .= '<p>email</p><input type="email" name="email"  placeholder="Email">';
            $html .= '<p>password</p><input type="password" name="password"  placeholder="Mot de passe">';
            $html .= '<p>password confirmation</p><input type="password" name="password2"  placeholder="Mot de passe">';
            $html .= '<div class="name"><div class="part"><p>nom</p><input type="text" name="nom"  placeholder="Nom"></div>';
            $html .= '<div class="part"><p>prenom</p><input type="text" name="prenom"  placeholder="Prenom"></div></div>';
            $html .= '<div class="gender"><input type="radio" name="genre" value="Femme">Femme';
            $html .= '<input type="radio" name="genre" value="Homme">Homme<br></div>';
            $html .= '<button type="submit">Inscription</button>';
            $html .= '</form>';
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            if($_POST['password'] != $_POST['password2']) {
                $html = "mot de passe different";
            }else {
                $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                $pass = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
                $nom = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
                $prenom = filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
                $genre = filter_var($_POST['genre'],FILTER_SANITIZE_STRING);
                Auth::register($email, $pass, $nom, $prenom, $genre);
            }
        }
        $html .= '</body></html>';
        return $html;
    }
}