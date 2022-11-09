<?php

namespace netvod\action;



use netvod\video\lists\ListeSerie;

class Lobby implements Action
{
    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $listeSerie = new ListeSerie();
            echo "lobby";

        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            //TODO
        }
        return $html;
    }
}