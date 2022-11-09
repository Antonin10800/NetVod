<?php

namespace netvod\action;



use netvod\render\ListeSerieRender;
use netvod\render\SerieRender;
use netvod\video\lists\ListeSerie;

class Lobby implements Action
{
    public function execute(): string
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="fr"> <head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<title>Inscription</title>';
        $html .= '<link rel="stylesheet" href="src/css/loby.css">';
        $html .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
        $html .= '</head><body>';

        $html .= '<header>';
        $html .= '<div class="headerLeft">';
        $html .= '<h1>NetVod</h1>';
        $html .= '</div>';
        $html .= '<div class="headerRight">';
        $html .= '<a href="?action=profile"><i  class="fa-solid fa-user"></i></a>';

        $html .= '</div>';
        $html .= '</header>';
        $listeSerie = new ListeSerie();
        $listeSerie->remplirListe();
        $listeSerieRender = new ListeSerieRender($listeSerie->getSeries());
        //$html .= $listeSerieRender->render();
        $html .= "<div class=\"content\">";
        $html .= $listeSerieRender->renderGenre("Horreur");
        $html .= $listeSerieRender->renderGenre("Comédie");
        $html .= $listeSerieRender->renderGenre("Thriller");
        $html .= $listeSerieRender->renderGenre("Divertissement");
        $html .= "</div>";

        $html .= '</body></html>';
        return $html;
    }
}