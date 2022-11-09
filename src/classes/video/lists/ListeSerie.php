<?php

namespace netvod\video\lists;

use netvod\db\ConnectionFactory;
use netvod\video\episode\Serie;
use netvod\utilitaire\Date;
use netvod\utilitaire\Avis;

class ListeSerie
{
    private array $listeSeries = [];

    private static ?ListeSerie $instance = null;

    public function __construct()
    {
    }

    public static function getInstance(): ?ListeSerie
    {
        if (is_null(self::$instance)) {
            self::$instance = new ListeSerie();
        }
        return self::$instance;
    }

    public function getSeries(): array
    {
        if(empty($this->listeSeries))
        {
            $this->remplirListe();
        }

        return $this->listeSeries;
    }

    public function remplirListe()
    {
        $db = ConnectionFactory::makeConnection();
        $req = $db->prepare("SELECT * FROM Serie");
        $req->execute();
        $result = $req->fetchAll();
        foreach ($result as $item)
        {
            $dateAjout = new Date($item['dateAjout']);
            $dateSortie = new Date($item['dateSortie']);
            $idSerie = intval($item['IDserie']);
            $serie = new Serie($idSerie, $item['titre'], $item['resume'], $item['genre'], $item['publicVise'], $dateAjout, $item['nbEpisode'], $dateSortie, $item['image']);

            $req = $db->prepare("SELECT * FROM Avis where IDserie = ?");
            $req->execute([$idSerie]);
            $result = $req->fetchAll();

            foreach ($result as $item)
            {
                $req2 = $db->prepare("SELECT nom FROM Utilisateur where IDUser = ?");
                $req2->execute([$item['IDUser']]);

                $avis = new Avis($item['note'], $item['commentaire'], $req2->fetch()['nom']);
                $serie->ajouterAvis($avis);

            }

            $this->listeSeries[] = $serie;
        }
    }




}