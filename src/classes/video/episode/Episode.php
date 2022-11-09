<?php

namespace netvod\video\episode;

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
     * @param int $IDepisode, int $duree, string $titre, string $image, int $numeroEp
     */
    public function __construct(int $IDepisode, int $duree, string $titre, string $image, int $numeroEp)
    {
        $this->IDepisode = $IDepisode;
        $this->duree = $duree;
        $this->titre = $titre;
        $this->image = 'src/classes/images/episodes/testEpisode.jpg';
        $this->numeroEp = $numeroEp;
    }


    /**
     * getter Magique
     * @param string $attribut
     */
    public function __get($name): mixed
    {
        if(property_exists($this,$name))
        {
            return $this->$name;
        }
        else throw new \Exception("la propriete n'existe pas");
    }
}