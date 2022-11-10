<?php
namespace netvod\action;

/**
 * class Deconnexion
 * qui permet de se déconnecter
 */
class Deconnexion implements Action
{
    /**
     * methode execute qui permet de se déconnecter
     * @return string le rendu de la page
     */
    public function execute(): string
    {
        $_SESSION['user'] = null;
        header("Location: ?action=connexion");
        return '';
    }
}
