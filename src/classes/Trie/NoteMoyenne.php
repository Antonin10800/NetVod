<?php

namespace netvod\Trie;

use netvod\action\Commentaire;
use netvod\db\ConnectionFactory;

class NoteMoyenne
{


    public static function trieNoteMoyenne($listeSerie): array
    {
        foreach ($listeSerie as $serie) {
            $IDserie = $serie->__get('IDserie');
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare("SELECT AVG(note) as moyenne FROM Avis WHERE IDserie = $IDserie");
            $stmt->execute();
            $result = $stmt->fetchAll();

            $listeSeriesTrieMoy = array();
            if (sizeof($listeSeriesTrieMoy) == 0) {
                $listeSeriesTrieMoy[] = $serie;
            } else {
                $i = 0;
                while ($i < sizeof($listeSeriesTrieMoy) && $result[0]['moyenne'] < $listeSeriesTrieMoy[$i]->__get('noteMoyenne')) {
                    $i++;
                }
                $listeSeriesTrieMoy = array_merge(array_slice($listeSeriesTrieMoy, 0, $i), array($serie), array_slice($listeSeriesTrieMoy, $i));
            }

        }
        return $listeSeriesTrieMoy;
    }
}