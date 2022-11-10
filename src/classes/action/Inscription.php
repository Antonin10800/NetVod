<?php

namespace netvod\action;


use netvod\auth\Auth;
use netvod\dispatch\Dispatcher;


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
        $html .= '<link rel="stylesheet" href="src/css/Inscription.css">';
        $html .= '<link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>';
        $html .= '</head><body background="src/images/css/netfix_background.jpeg">';

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $html .= '<form class="form" method="post" action="?action=inscription">';
            $html .= '<div class="title"><h1>Inscription</h1></div>';
            $html .= '<p>Email</p><input class="input" type="email" name="email" >';
            $html .= '<p>Password</p><input type="password" name="password" >';
            $html .= '<p>Password confirmation</p><input class="input" type="password" name="password2" >';
            $html .= '<div class="name"><div class="part"><p>Nom</p><input type="text" name="nom"></div>';
            $html .= '<div class="part"><p>Prenom</p><input class="input" type="text" name="prenom"></div></div>';
            $html .= '<div class="gender"><input class="input" type="radio" name="genre" value="Femme">Femme';
            $html .= '<input type="radio" class="input" name="genre" value="Homme">Homme<br></div>';
            $html .= '<button type="submit">Inscription</button>';
            $html .= '</form>';

        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {     
            if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2']) || empty($_POST['nom'])
            || empty($_POST['prenom']) || empty($_POST['genre'])) {
                $html .= '<form class="form" method="post" action="?action=inscription">';
                $html .= '<div class="title"><h1>Inscription</h1></div>';
                $html .= '<p>Email</p><input class="input" type="email" name="email" >';
                $html .= '<p>Password</p><input type="password" name="password" >';
                $html .= '<p>Password confirmation</p><input class="input" type="password" name="password2" >';
                $html .= '<div class="name"><div class="part"><p>Nom</p><input type="text" name="nom"></div>';
                $html .= '<div class="part"><p>Prenom</p><input class="input" type="text" name="prenom"></div></div>';
                $html .= '<div class="gender"><input class="input" type="radio" name="genre" value="Femme">Femme';
                $html .= '<input type="radio" class="input" name="genre" value="Homme">Homme<br></div>';
                $html .= '<div class="error"><p>Tous les champs doivent être renseignés !</p></div>';
                $html .= '<button id="disable" type="submit">Inscription</button>';
                $html .= '</form>';
            } else if ($_POST['password'] != $_POST['password2']) {
                $html .= '<form class="form" method="post" action="?action=inscription">';
                $html .= '<div class="title"><h1>Inscription</h1></div>';
                $html .= '<p>Email</p><input class="input" type="email" name="email" >';
                $html .= '<p>Password</p><input type="password" name="password" >';
                $html .= '<p>Password confirmation</p><input class="input" type="password" name="password2" >';
                $html .= '<div class="error"><p>Les mots de passes ne sont pas identiques !</p></div>';
                $html .= '<div class="name"><div class="part"><p>Nom</p><input type="text" name="nom"></div>';
                $html .= '<div class="part"><p>Prenom</p><input class="input" type="text" name="prenom"></div></div>';
                $html .= '<div class="gender"><input class="input" type="radio" name="genre" value="Femme">Femme';
                $html .= '<input type="radio" class="input" name="genre" value="Homme">Homme<br></div>';
                $html .= '<button type="submit">Inscription</button>';
                $html .= '</form>';
            } else {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
                $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
                $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
                $res = Auth::register($email, $pass, $nom, $prenom, $genre);
                if ($res == 1) {
                    Auth::authentificate($email, $pass);
                    $token = Auth::genererToken($email);
                    header("Location: ?action=activation&token=$token");
                    return '';
                } elseif ($res == -1) {
                    $html .= '<form class="form" method="post" action="?action=inscription">';
                    $html .= '<div class="title"><h1>Inscription</h1></div>';
                    $html .= '<p>Email</p><input class="input" type="email" name="email" >';
                    $html .= '<p>Password</p><input type="password" name="password" >';
                    $html .= '<p>Password confirmation</p><input class="input" type="password" name="password2" >';
                    $html .= '<div class="error"><p>Les mots de passes sont trop court !</p></div>';
                    $html .= '<div class="name"><div class="part"><p>Nom</p><input type="text" name="nom"></div>';
                    $html .= '<div class="part"><p>Prenom</p><input class="input" type="text" name="prenom"></div></div>';
                    $html .= '<div class="gender"><input class="input" type="radio" name="genre" value="Femme">Femme';
                    $html .= '<input type="radio" class="input" name="genre" value="Homme">Homme<br></div>';
                    $html .= '<button type="submit">Inscription</button>';
                    $html .= '</form>';
                }
                else{
                    $html .= '<form class="form" method="post" action="?action=inscription">';
                    $html .= '<div class="title"><h1>Inscription</h1></div>';
                    $html .= '<p>Email</p><input class="input" type="email" name="email" >';
                    $html .= '<p>Password</p><input type="password" name="password" >';
                    $html .= '<p>Password confirmation</p><input class="input" type="password" name="password2" >';
                    $html .= '<div class="error"><p>Une erreur vient de se produire</p></div>';
                    $html .= '<div class="name"><div class="part"><p>Nom</p><input type="text" name="nom"></div>';
                    $html .= '<div class="part"><p>Prenom</p><input class="input" type="text" name="prenom"></div></div>';
                    $html .= '<div class="gender"><input class="input" type="radio" name="genre" value="Femme">Femme';
                    $html .= '<input type="radio" class="input" name="genre" value="Homme">Homme<br></div>';
                    $html .= '<button type="submit">Inscription</button>';
                    $html .= '</form>';
                }
            }
        }
        $html .= '</body></html>';
        return $html;
    }
}