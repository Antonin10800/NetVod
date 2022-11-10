<?php

namespace netvod\video\lists;

use netvod\db\ConnectionFactory;
use netvod\video\episode\Serie;
use netvod\utilitaire\Date;
use netvod\utilitaire\Avis;

/**
 * class ListeSerie
 * permet de charger les series
 */
class ListeSerie
{
    /**
     * @var array $listeSerie la liste des series
     */
    private array $listeSeries = [];
    private static ?ListeSerie $instance = null;

    /**
     * constructeur vide de la classe ListeSerie
     */
    public function __construct(){}

    /**
     * methode getInstance qui permet de retourner l'instance de la classe ListeSerie
     * @return ListeSerie l'instance de la classe ListeSerie
     */
    public static function getInstance(): ?ListeSerie
    {
        if (is_null(self::$instance)) {
            self::$instance = new ListeSerie();
        }
        return self::$instance;
    }

    /**
     * methode getSeries qui permet de retourner la liste des series
     * @return array la liste des series
     */
    public function getSeries(): array
    {
        if(empty($this->listeSeries))
        {
            $this->remplirListe();
        }

        return $this->listeSeries;
    }

    /**
     * methode remplirListe qui permet de remplir la liste des series
     * en les chargant depuis la base de données
     * @return void
     */
    private function remplirListe() : void
    {
        //on recupere toute les série
        $db = ConnectionFactory::makeConnection();
        $req = $db->prepare("SELECT * FROM Serie");
        $req->execute();
        $result = $req->fetchAll();
        foreach ($result as $item)
        {
            //on ajoute toute les variables
            $dateAjout = new Date($item['dateAjout']);
            $dateSortie = new Date($item['dateSortie']);
            $idSerie = intval($item['IDserie']);
            $serie = new Serie($idSerie, $item['titre'], $item['resume'], $item['genre'], $item['publicVise'], $dateAjout, $item['nbEpisode'], $dateSortie, $item['image']);

            $this->listeSeries[] = $serie;
        }
        $req->closeCursor();
        $this->actualiserAvis();
    }

    /**
     * methode actualiserAvis qui permet d'actualiser les avis des series
     */
    public function actualiserAvis():void
    {
        $db = ConnectionFactory::makeConnection();

        $req = $db->prepare("SELECT note, commentaire, nom, U.IDUser, IDSerie FROM Avis inner join Utilisateur U on Avis.IDUser = U.IDUser");
        $req->execute();
        $result = $req->fetchAll();
        foreach ($this->listeSeries as $serie)
        {
            $serie->viderAvis();
        }
        foreach ($result as $item)
        {
            $avis = new Avis($item['note'], $item['commentaire'], $item['nom'] , $item['IDUser'], $item['IDSerie']);
            foreach ($this->listeSeries as $serie)
            {
                if($serie->IDserie == $item['IDSerie'])
                {
                    $serie->ajouterAvis($avis);
                    break;
                }
            }
        }
        foreach ($this->listeSeries as $serie)
        {
            $serie->calculerMoyenne();
        }

    }

        public function rechercherSerie(string $recherche): array
        {
            foreach ($this->listeSeries as $serie)
            {
                if(str_contains($serie->titre,$recherche))
                {
                    $res[] = $serie;
                }

            }
            return $res;
        }


}