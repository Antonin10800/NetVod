<?php

namespace netvod\action;

class Profil implements Action
{
    public function execute(): string
    {
        $html = '';
        $html .= '<div class="profile">';
        $html .= '<a>Email : ' . unserialize($_SESSION['user'])->__get('email') . '</a><br>';
        $html .= '<a>Nom : ' . unserialize($_SESSION['user'])->__get('nom') . '</a><br>';
        $html .= '<a>Prenom : ' . unserialize($_SESSION['user'])->__get('prenom') . '</a><br>';
        $html .= '<a>Sexe : ' . unserialize($_SESSION['user'])->__get('sexe') . '</a><br>';
        $html .= '</div>';

        return $html;
    }
}