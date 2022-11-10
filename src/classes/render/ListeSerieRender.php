<?php


namespace netvod\render;
use netvod\Trie\NoteMoyenne;
use netvod\video\lists\ListeSerie;

/**
 * classe ListeSerieRender
 * qui permet le rendu d'une liste de série
 */
class ListeSerieRender implements Render {

    /**
     * @var array liste de série que l'on souhaite rendre
     */
    private array $listeSerie;

    /**
     * constructeur de la classe ListeSerieRender
     * initialise la variable listeSerie
     * @param array $listeSerie liste de série que l'on souhaite ajouter à la variable
     */
    public function __construct(array $listeSerie){
        $this->listeSerie = $listeSerie;
    }

    /** fonction render qui permet le rendu d'une liste de série
     * @param ListeSerie $listeSerie la liste de série à retourner
     * @return string le rendu de la liste de série
     */
    public function render() : string {
        $res = "<div class=\"liste-series\">";
        foreach ($this->listeSerie as $series) {
            $serie = new SerieRender($series);
            $res .= $serie->render();
        }
        $res .= "</div>";
        return $res;
    }


    /**
     * fonction renderGenre qui fait le rendu en fonction du genre
     * @param string $genre le genre de la série
     */
    public function renderGenre(string $genre) : string {
        $res = "<div class=\"genre-serie\">";
        $res .= "<h2>{$genre}</h2>";
        $res .= "<div class=\"liste-series\">";
        foreach ($this->listeSerie as $series) {
            if($series->genre == $genre) {
                $serie = new SerieRender($series);
                $res .= $serie->render();
            }
        }
        $res .= "</div></div>";
        return $res;
    }


    /**
     * méthode qui permet d'afficher par classement
     * @return string classement
     */
    public function renderParClassement(){
        $res = "<div class=\"genre-serie\">";
        $res .= "<h2>Classement des meilleurs série</h2>";
        $res .= "<div class=\"liste-series\">";
        $listetemp = NoteMoyenne::trieNoteMoyenne($this->listeSerie);
        foreach ($listetemp as $series) {
            $serie = new SerieRender($series);
            $res .= $serie->render();
        }
        $res .= "</div></div>";
        if(sizeof($listetemp)==0)
        {
            return '';
        }
        return $res;
    }

    /**
     * méthode qui permet d'afficher la liste des favoris
     * @return string liste des favoris
     */
    public function renderFavoris(): string
    {
        $utilisateur = unserialize($_SESSION['user']);
        $favoris = $utilisateur->favoris;
        if(count($favoris)>0)
        {
            /**echo "<pre>";
            var_dump($favoris);
            die();*/
            $res = "<div class=\"genre-serie\">";
            $res .= '<h2>Vos préférences</h2>';
            $res .= '<div class="liste-series">';
            foreach ($favoris as $fav)
            {
                $serie = new SerieRender($fav);
                $res .= $serie->render();
            }
            $res .= "</div></div>";
        }
        else
        {
            $res = "";
        }
        return $res;
    }


    public function renderRecherche(string $recherche) : string
    {
        $res = "<div class=\"genre-serie\">";
        $res .= "<h2>Résultat de la recherche</h2>";
        $res .= "<div class=\"liste-series\">";
        foreach ($this->listeSerie as $series) {
            if (str_contains(strtolower($series->titre) ,strtolower($recherche)  )) {
                $serie = new SerieRender($series);
                $res .= $serie->render();
            }
        }
        $res .= "</div></div>";
        return $res;
    }
    public function renderEncours():string
    {
        $utilisateur = unserialize($_SESSION['user']);
        $encours = $utilisateur->enCours;
        if(count($encours)>0)
        {
            /**echo "<pre>";
            var_dump($favoris);
            die();*/
            $res = "<div class=\"genre-serie\">";
            $res .= '<h2>Reprendre</h2>';
            $res .= '<div class="liste-series">';
            foreach ($encours as $cours)
            {
                $serie = new SerieRender($cours);
                $res .= $serie->render();
            }
            $res .= "</div></div>";
        }
        else
        {
            $res = "";
        }

        return $res;
    }
}