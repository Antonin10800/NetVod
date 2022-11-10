<?php


namespace netvod\render;

use netvod\action\Favoris;
use netvod\video\episode\Serie;
use netvod\video\lists\ListeSerie;
use netvod\db\ConnectionFactory;

/**
 * classe SerieRender
 * qui permet le rendu d'une série et de ses épisodes
 */
class RenderInfoSerie implements Render
{

    /**
     * @var Serie série que l'on souhaite rendre
     */
    private Serie $serie;
    /**
     * @var array tableaux d'épisodes de la série
     */
    private array $episodes;

    /**
     * constructeur de la classe SerieRender
     * initialise la variable série
     * @param Serie $serie série que l'on souhaite ajouter à la variable
     */
    public function __construct(Serie $serie)
    {
        $this->serie = $serie;
        $this->episodes = $this->serie->getEpisodes();
    }

    /** fonction render qui permet le rendu d'une série et de ses épisodes
     * @param Serie $serie la série à retourner
     * @return string le rendu de la série
     */
    public function render(): string
    {
        $res = '<!DOCTYPE html>';
        $res .= '<html lang="fr"> <head>';
        $res .= '<meta charset="UTF-8">';
        $res .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $res .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $res .= '<title>NetVod</title>';
        $res .= '<link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>';
        $res .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
        $res .= '<link rel="stylesheet" href="src/css/renderInfo.css">';
        $res .= '</head><body>';

        $res .= <<<END
            <header>
                <div class="headerLeft">
                    <a href="?action=lobby">NETVOD</a>
                </div>
            </header>
            <div class="headerInfo">
                <div class="headerTop">
                    <div class="headerLeft">
                        <img class="image-serie" src="{$this->serie->image}">
                    </div>
                    <div class="headerRight">
                        <div class="titre">
                            <h1>{$this->serie->titre}</h1>
                            <hr>
                        </div>
                        <div class="resume">
                            <p>{$this->serie->resume}</p>
                        </div>
                        <div class="genre">
                            <h1>{$this->serie->genre}</h1>
                            <h1>{$this->serie->nbEpisode} épisodes</h1>
                            <h1>{$this->serie->public}</h1>
                        </div>
                    </div>
                </div>
                <div class="headerBot">
                    <h1>{$this->serie->dateAjout->toString()}</h1>
            END;
        if(Favoris::pasDeFavoris()) {
            $res .= <<<END
                <a onclick="ajouterFav()" href="?action=favoris&idSerie={$this->serie->IDserie}"><i id="notFav" class="fa-regular fa-bookmark"></i></a>
            END;
        } else {
            $res .= <<<END
                <a onclick="enleverFav()" href="?action=favoris&idSerie={$this->serie->IDserie}"><i id="Fav" class="fa-solid fa-bookmark"></i></a>
            END;
        }
        $res .= "</div>";

        $res .= '</div></div>';
        $res .= '<div class="episodes">';
        foreach ($this->episodes as $episode) {
            $res .= <<<END
                <div class="episodes-serie">
                    <div class="img">
                        <a href="?action=afficher-episode&idSerie={$this->serie->IDserie}&numEp={$episode->numeroEp}"><img class="img-episode" src='{$episode->image}'></a>
                        <p class="duree"> {$episode->duree} </p>
                    </div>
                    <div class="titre-episode">
                        <h1>{$episode->numeroEp} - {$episode->titre}</h1>
                    </div>
                </div>
                END;
        }
        $res .= '</div>';
        $res .= '<div class="commentaire">'
                    . '<h1>Voir les commentaires</h1>';
                $res .= "<a href=\"?action=commentaires&idSerie={$this->serie->IDserie}\">Commentaire</a>";
        $res .= '</div>';
        $res .= '</body></html>';
        return $res;
    }

}