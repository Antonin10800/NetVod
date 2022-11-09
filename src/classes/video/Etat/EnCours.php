<?php

namespace netvod\video\Etat;

use netvod\auth\Auth;
use netvod\db\ConnectionFactory;

class EnCours
{
    /**
     * Serie en cours de visionnage
     */


    public static function enCours($IDserie): bool
    {
        $query = "SELECT * FROM enCours WHERE IDserie = ?";
        $db = ConnectionFactory::makeConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$IDserie]);


        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function ajouterEnCours($IDserie)
    {

        if (!self::enCours()) {
            $query = "INSERT INTO enCours (IDserie) VALUES (?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute($IDserie);

        }
    }

    public function supprimerEnCours($IDserie)
    {

        if (self::enCours()) {
            $query = "DELETE FROM enCours WHERE IDserie = ?";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute($IDserie);

        }
    }

}