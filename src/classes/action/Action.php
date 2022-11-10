<?php

namespace netvod\action;

/**
 * interface Action
 * qui permet de définir la méthodes des actions
 */
interface Action
{
    /**
     * methode execute qui permet d'executer l'action
     * @return string le rendu de la page
     */
    public function execute(): string;
}