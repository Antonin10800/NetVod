<?php
namespace netvod\action;

class Deconnexion implements Action
{
    public function execute(): string
    {
        $_SESSION['user'] = null;
        header("Location: ?action=connexion");
        return '';
    }
}
