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
        $res = <<<END
            <img class="image-serie" src="{$this->serie->image}">
            
        END;
        if(Favoris::pasDeFavoris())
        {
            $res .= <<<END
                <a href="?action=favoris&idSerie={$this->serie->IDserie}">Ajouter au favoris</a>
            END;
        }
        else
        {
            $res .= <<<END
                <a href="?action=favoris&idSerie={$this->serie->IDserie}">Supprimer des favoris</a>
            END;
        }
        $res .= <<<END
            <a href="?action=commentaires&idSerie={$this->serie->IDserie}">Commentaire</a>
            <p>{$this->serie->titre}<br>
            {$this->serie->resume}<br>
            {$this->serie->genre}<br>
            {$this->serie->public}
            {$this->serie->dateAjout->toString()}<br>
            {$this->serie->nbEpisode}<br>
            {$this->serie->dateSortie->toString()}<br>
            </p>
            END;

        foreach ($this->episodes as $episode) {
            $res .= <<<END
                <div> <a href="?action=afficher-episode&idSerie={$this->serie->IDserie}&numEp={$episode->numeroEp}">
                <img src='{$episode->image}'>
                {$episode->numeroEp}<br>
                {$episode->titre}<br>
                {$episode->duree}</a></div>
                END;

        }
        return $res;
    }

}