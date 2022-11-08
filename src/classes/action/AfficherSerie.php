<?php

namespace netvod\action;

use Action;

class AfficherSerie implements Action
{
    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //TODO
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            //TODO
        }
        return $html;
    }
}