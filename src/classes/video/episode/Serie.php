<?php

namespace netvod\video\episode;

use netvod\db\ConnectionFactory;
use netvod\utilitaire\Date;
use netvod\video\lists\ListeSerie;
use netvod\utilitaire\Avis;

/**
 * class Serie
 */
class Serie
{

    /**
     * @var int $IDepisode l'id de la serie
     * @var string $titre le titre de la serie
     * @var string $resume le resume de la serie
     * @var string $genre le genre de la serie
     * @var string $public le public de la serie
     * @var Date $dateAjout la date d'ajout de la serie sur le site
     * @var int $nbEpisode le nombre d'episode de la serie
     * @var Date $dateSortie la date de sortie de la serie
     * @var string $image la position de l'image de la serie
     * @var array $avis la liste des avis de la serie
     * @var array $listeEpisode la liste des episodes de la serie
     */
    private int $IDepisode;
    private string $titre;
    private string $resume;
    private string $genre;
    private string $public;
    private Date $dateAjout;
    private int $nbEpisode;
    private Date $dateSortie;
    private string $image;
    private array $avis = array();
    private array $listeEpisode = array();

    /**
     * constructeur de la class Serie qui prends en paramètre 
     * tout les attributs de la class
     * @param int $IDserie l'id de la serie
     * @param string $titre le titre de la serie
     * @param string $resume le resume de la serie
     * @param string $genre le genre de la serie
     * @param string $public le public de la serie
     * @param Date $dateAjout la date d'ajout de la serie sur le site
     * @param int $nbEpisode le nombre d'episode de la serie
     * @param Date $dateSortie la date de sortie de la serie
     */
    public function __construct(int $IDserie, string $titre, string $resume, string $genre, string $public, Date $dateAjout, int $nbEpisode, Date $dateSortie, string $image)
    {
        $this->titre = $titre;
        $this->IDserie = $IDserie;
        $this->resume = $resume;
        $this->genre = $genre;
        $this->public = $public;
        $this->dateAjout = $dateAjout;
        $this->nbEpisode = $nbEpisode;
        $this->dateSortie = $dateSortie;
        $this->image = 'src/classes/images/series/image.jpeg';
        $this->setEpisodes();
    }

    /**
     * méthode ajouterAvis qui permet d'ajouter un avis à la série
     * @param avis $avis l'avis à ajouter
     */
    public function ajouterAvis(Avis $avis)
    {
        $this->avis[] = $avis;
    }

    /**
     * getter Magique
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * setter Magique
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * methode getEpisodes qui permet de recuperer la liste des episodes de la serie
     * @return array la liste des episodes de la serie
     */
    public function getEpisodes(): array
    {
        return $this->listeEpisode;
    }

    /**
     * methode setEpisodes qui permet de charger les épisodes depuis la base de données et les ajouters
     * à la liste des épisodes de la série
     * @return void
     */
    public function setEpisodes(): void
    {
        if ($this->listeEpisode == null) //si la série a une liste null:
        {
            //on récupére la liste des épisodes de la série:
            $query = "select E.idEpisode, titre, duree, image,numEp from Serie2Episode inner join 
                            Episode E on Serie2Episode.IDEpisode = E.idEpisode
                            where Serie2Episode.IDSerie = ?";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute([$this->IDserie]);
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $episode = new Episode($row['idEpisode'], $row['duree'], $row['titre'], $row['image'], $row['numEp']);
                $this->listeEpisode[] = $episode;
            }
        }
    }

    public static function getSerie(int $idSerie):Serie
    {
        $serie = null;
        $db = ConnectionFactory::makeConnection();
        $req = $db->prepare("SELECT * FROM Serie WHERE IDserie = ?");
        $req->bindParam(1, $idSerie);
        $req->execute();
        $result = $req->fetchAll();
        foreach ($result as $item) {
            //on ajoute toute les variables
            $dateAjout = new Date($item['dateAjout']);
            $dateSortie = new Date($item['dateSortie']);
            $serie = new Serie($idSerie, $item['titre'], $item['resume'], $item['genre'], $item['publicVise'], $dateAjout, $item['nbEpisode'], $dateSortie, $item['image']);

            $req = $db->prepare("SELECT * FROM Avis where IDserie = ?");
            $req->execute([$idSerie]);
            $res = $req->fetchAll();

            foreach ($res as $item) {
                $req2 = $db->prepare("SELECT nom FROM Utilisateur where IDUser = ?");
                $req2->execute([$item['IDUser']]);

                $avis = new Avis($item['note'], $item['commentaire'], $req2->fetch()['nom']);
                $serie->ajouterAvis($avis);

            }
        }
        return $serie;
    }

}