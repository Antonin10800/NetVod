<?php

namespace netvod\action;



use netvod\render\ListeSerieRender;
use netvod\render\SerieRender;
use netvod\video\lists\ListeSerie;

class Lobby implements Action
{
    public function execute(): string
    {
        $html = <<<END
            <!DOCTYPE html>
            <html lang="fr"> <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>NetVod</title>
            <script src="src/js/profile.js"></script>
            <link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>
            <link rel="stylesheet" href="src/css/loby.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            </head><body>

            <header>
                <div class="headerLeft">
                    <h1>NETVOD</h1>
                </div>
                <div class="headerRight">
                    <a onclick="profilePage()"><i  class="fa-solid fa-user"></i></a>
                </div>
            </header>
            END;

        $listeSerie = new ListeSerie();
        $listeSerieRender = new ListeSerieRender($listeSerie->getSeries());

        //$html .= $listeSerieRender->render();
        $html .= "<div class=\"content\">";
        $html .= $listeSerieRender->renderFavoris();
        $html .= $listeSerieRender->renderGenre("Comédie");
        $html .= $listeSerieRender->renderGenre("Horreur");
        $html .= $listeSerieRender->renderGenre("Divertissement");
        $html .= $listeSerieRender->renderParClassement();
        $html .= "</div>";

        $html .= "<div class=\"content-profile\">";
        $html .= '<div class="profile">';
        $html .= '<a onclick="hideProfilePage()"><i class="fa-solid fa-xmark"></i></a>';
        $html .= '<a>Email : ' . unserialize($_SESSION['user'])->email . '</a><br>';
        $html .= '<a>Nom : ' . unserialize($_SESSION['user'])->nom . '</a><br>';
        $html .= '<a>Prenom : ' . unserialize($_SESSION['user'])->prenom . '</a><br>';
        $html .= '<a>Sexe : ' . unserialize($_SESSION['user'])->sexe . '</a><br>';

        // bouton de déconnexion
        $html .= '<a class="btn-deconnexion" href="?action=deconnexion"><i class="fa-solid fa-arrow-right-from-bracket"></i>  Déconnexion</a>';
        $html .= '</div></div>';

        $html .= '</body></html>';
        return $html;
    }
}