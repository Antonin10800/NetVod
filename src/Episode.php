<?php

class Episode
{
    private int $IDepisode;
    private int $duree;
    private string $titre;
    private string $image;
    private int $numeroEp;

    /**
     * constructeur de la class Episode qui prends en paramètre 
     * tout les attributs de la class
     */
    public function __construct(int $IDepisode, int $duree, string $titre, string $image, int $numeroEp)
    {
        $this->IDepisode = $IDepisode;
        $this->duree = $duree;
        $this->titre = $titre;
        $this->image = $image;
        $this->numeroEp = $numeroEp;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}