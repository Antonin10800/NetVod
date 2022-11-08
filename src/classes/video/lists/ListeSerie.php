<?php

namespace netvod\video\lists;

use netvod\db\ConnectionFactory;

class ListeSerie
{
    private static array $listeSeries = [];

    public function __construct()
    {
    }

    public static function getInstance(): ListeSerie
    {
        static $instance = [];
        if (self::$listeSeries === null) {
            $instance = new ListeSerie();
            $db = ConnectionFactory::makeConnection();
        }
        else
        {
            $instance = self::$listeSeries;
        }
        return $instance;
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