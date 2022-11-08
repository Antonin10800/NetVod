<?php

namespace netvod\action;

class Inscription implements Action
{
    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= '<form method="post" action="?action=inscription">';
            $html .= '<input type="email" name="email"  placeholder="Email">';
            $html .= '<input type="password" name="password"  placeholder="Mot de passe">';
            $html .= '<input type="password" name="password2"  placeholder="Mot de passe">';
            $html .= '<input type="text" name="nom"  placeholder="Nom">';
            $html .= '<input type="text" name="prenom"  placeholder="Prenom">';
            $html .= '<input type="radio" name="Genre" value="Femme">Femme';
            $html .= '<input type="radio" name="Genre" value="Homme">Homme<br>';
            $html .= '<button type="submit">Connexion</button>';
            $html .= '</form>';
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            //TODO
        }
        return $html;
    }
}