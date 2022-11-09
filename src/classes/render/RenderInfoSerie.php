<?php


namespace netvod\render;

use netvod\action\Favoris;
use netvod\video\episode\Serie;

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
        $res .= '<title>Inscription</title>';
        $res .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
        $res .= '<link rel="stylesheet" href="src/css/renderInfo.css">';
        $res .= '</head><body>';

        $res .= <<<END
            <div class="headerInfo">
                <div class="headerTop">
                    <div class="headerLeft">
                        <img class="image-serie" src="{$this->serie->image}">
                    </div>
                    <div class="headerRight">
                        <div class="titre">
                            <h1>{$this->serie->titre}</h1>
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
                <a href="?action=favoris&idSerie={$this->serie->IDserie}"><i class="fa-regular fa-bookmark"></i></a>
            END;
        } else {
            $res .= <<<END
                <a href="?action=favoris&idSerie={$this->serie->IDserie}"><i class="fa-solid fa-bookmark"></i></a>
            END;
        }
        $res .= "</div>";
        $res .= "<a href=\"?action=commentaires&idSerie={$this->serie->IDserie}\">Commentaire</a>";

        $res .= '</div></div>';
        foreach ($this->episodes as $episode) {
            $res .= <<<END
                <div class="episodes-serie"> <a href="?action=afficher-episode&idSerie={$this->serie->IDserie}&numEp={$episode->numeroEp}">
                <img class="img-episode" src='{$episode->image}'>
                {$episode->numeroEp}<br>
                {$episode->titre}<br>
                {$episode->duree}</a></div>
                END;

        }
        return $res;
    }

}