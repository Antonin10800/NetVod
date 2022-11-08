<?php

class Serie 
{
    private string $titre;
    private int $IDserie;
    private string $resume;
    private string $genre;
    private string $public;
    private string $dateAjout;
    private int $nbEpisode;
    private array $avis = array();

    /**
     * constructeur de la class Serie qui prends en paramètre 
     * tout les attributs de la class
     */
    public function __construct(string $titre, int $IDserie, string $resume, string $genre, string $public, string $dateAjout, int $nbEpisode)
    {
        $this->titre = $titre;
        $this->IDserie = $IDserie;
        $this->resume = $resume;
        $this->genre = $genre;
        $this->public = $public;
        $this->dateAjout = $dateAjout;
        $this->nbEpisode = $nbEpisode;
    }

    /**
     * méthode ajouterAvis
     * @param Avis $avis
     */
    public function ajouterAvis(Avis $avis)
    {
        // pour ajouter en fin d'un tableau on met crochet vide :-)
        $this->avis[] = $avis;
    }

    /**
     * getter Magique
     */
    public function __get($name)
    {
        return $this->$name;
    }
}