<?php

use netvod\db\ConnectionFactory;

class ListeSerie
{
    private static array $listeSeries = [];

    public function __construct()
    {
    }

    public static function getInstance(): array
    {
        if (self::$listeSeries === null) {
            $db = ConnectionFactory::makeConnection();
            $req = $db->prepare("SELECT * FROM Serie");
            $req->execute();
            $result = $req->fetchAll();
            foreach ($result as $item)
            {
                $dateAjout = new Date($item['dateAjout']);
                $dateSortie = new Date($item['dateSortie']);
                $serie = new Serie($item['IDserie'], $item['titre'], $item['resume'], $item['genre'], $item['public'], $dateAjout, $item['nbEpisode'], $dateSortie);
                self::$listeSeries[] = $serie;
            }
        }
        return self::$listeSeries;
    }

    public static function ajouterSerie(Serie $serie)
    {
        // pour ajouter en fin d'un tableau on met crochet vide :-)
        self::$listeSeries[] = $serie;
    }

    public static function supprimerSerie(Serie $serie)
    {
        // on cherche l'index de la série dans le tableau
        $index = array_search($serie, self::$listeSeries);
        // on supprime l'élément du tableau
        unset(self::$listeSeries[$index]);
    }

    public static function getNbSeries(): int
    {
        return count(self::$listeSeries);
    }

    public static function getSeries(): array
    {
        return self::$listeSeries;
    }

    public static function getSeriesByGenre(string $genre): array
    {
        $series = [];
        foreach (self::$listeSeries as $serie) {
            if ($serie->genre === $genre) {
                $series[] = $serie;
            }
        }
        return $series;
    }

    public static function getSeriesByPublic(string $public): array
    {
        $series = [];
        foreach (self::$listeSeries as $serie) {
            if ($serie->public === $public) {
                $series[] = $serie;
            }
        }
        return $series;
    }


}