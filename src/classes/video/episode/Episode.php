<?php

namespace netvod\video\episode;

/**
 * class Episode
 */
class Episode
{
    /**
     * @var int $IDepisode l'identifiant de l'episode
     * @var int $duree la duree de l'episode
     * @var string $nom le titre de l'episode
     * @var string $image la position de l'image de l'episode
     * @var int $numeroEp le numero de l'episode
     */
    private int $IDepisode;
    private int $duree;
    private string $titre;
    private string $image;
    private int $numeroEp;

    /**
     * constructeur de la class Episode qui prends en paramètre 
     * tout les attributs de la class et les initialises
     * @param int $IDepisode l'identifiant de l'episode
     * @param int $duree la duree de l'episode
     * @param string $titre le titre de l'episode
     * @param string $image la position de l'image de l'episode
     * @param int $numeroEp le numero de l'episode
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
    public function __get($name) : mixed
    {
        if(property_exists($this,$name))
        {
            return $this->$name;
        }
        else throw new \Exception("la propriete n'existe pas");
    }
}