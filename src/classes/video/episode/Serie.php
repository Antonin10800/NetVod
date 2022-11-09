<?php

namespace netvod\video\episode;

use netvod\db\ConnectionFactory;
use netvod\utilitaire\Date;
use netvod\video\lists\ListeSerie;
use netvod\utilitaire\Avis;

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
    private string $image;
    private array $avis = array();
    private array $listeEpisode = array();

    /**
     * constructeur de la class Serie qui prends en paramètre 
     * tout les attributs de la class
     * @param int $IDserie, string $titre, string $resume, string $genre, string $public, Date $dateAjout, int $nbEpisode, Date $dateSortie
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
     * méthode ajouterAvis
     * @param avis $avis
     */
    public function ajouterAvis(Avis $avis)
    {
        // pour ajouter en fin d'un tableau on met crochet vide :-)
        $this->avis[] = $avis;
    }

    /**
     * getter Magique
     * @param string $attribut
     */
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function getEpisodes(): array
    {
        return $this->listeEpisode;
    }

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

    public function getSerie(int $idSerie):Serie
    {
        $db = ConnectionFactory::makeConnection();
        $req = $db->prepare("SELECT * FROM Serie WHERE IDserie = ?");
        $req->bindParam(1, $idSerie);
        $req->execute();
        $result = $req->fetchAll();
        foreach ($result as $item) {
            //on ajoute toute les variables
            $dateAjout = new Date($item['dateAjout']);
            $dateSortie = new Date($item['dateSortie']);
            $idSerie = intval($item['IDserie']);
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
            return $serie;
        }
    }

}