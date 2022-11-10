<?php

namespace netvod\Trie;

use netvod\action\Commentaire;
use netvod\db\ConnectionFactory;

class NoteMoyenne
{

    /**
     * @param $listeSerie liste à trier
     * @return array liste triée par les moyennes des séries
     */
    public static function trieNoteMoyenne($listeSerie): array
    {
        $listeSeriesTrieMoy = [];
        foreach ($listeSerie as $serie) {
            if($serie->noteMoyenne !=0){
            if ($listeSeriesTrieMoy == null) {
                $listeSeriesTrieMoy[] = $serie;
            } else {
                $i = 0;
                $moyenne = $serie->noteMoyenne;
                while ($i < count($listeSeriesTrieMoy) && $moyenne < $listeSeriesTrieMoy[$i]->noteMoyenne) {
                    $i++;
                }
                $p1 = array_slice($listeSeriesTrieMoy, 0, $i);
                $p2 = array_slice($listeSeriesTrieMoy, $i);
                $listeSeriesTrieMoy = array_merge($p1, [$serie], $p2);


            }
        }}
        return $listeSeriesTrieMoy;
    }
}