<?php

namespace netvod\video\episode;

class Serie 
{
    private int $IDserie;
    private string $titre;
    private string $resume;
    private string $genre;
    private string $public;
    private Date $dateAjout;
    private int $nbEpisode;
    private Date $dateSortie;
    private array $avis = array();

    /**
     * constructeur de la class Serie qui prends en paramètre 
     * tout les attributs de la class
     */
    public function __construct(string $titre, int $IDserie, string $resume, string $genre, string $public, Date $dateAjout, int $nbEpisode, Date $dateSortie)
    {
        $this->titre = $titre;
        $this->IDserie = $IDserie;
        $this->resume = $resume;
        $this->genre = $genre;
        $this->public = $public;
        $this->dateAjout = $dateAjout;
        $this->nbEpisode = $nbEpisode;
        $this->dateSortie = $dateSortie;
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