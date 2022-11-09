<?php

namespace netvod\video\Etat;

use netvod\auth\Auth;
use netvod\db\ConnectionFactory;

class EnCours
{
    /**
     * Serie en cours de visionnage
     */


    public static function enCours(int $IDserie, int $user): bool
    {
        $db = ConnectionFactory::makeConnection();
        $stmt = $db->prepare("SELECT * FROM enCours WHERE IDserie = $IDserie and IDuser = $user");
        $stmt->execute();
        $result = $stmt->fetchAll();
        echo "resultat: " . sizeof($result);

        echo $IDserie;
        echo $user;
        echo sizeof($result);
        if (sizeof($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function ajouterEnCours($IDserie)
    {

        $user = unserialize($_SESSION['user']);
        $userId = $user->IDuser;
        if (!self::enCours($IDserie, $userId)) {
            $query = "INSERT INTO enCours  VALUES (?,?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute([$userId, $IDserie]);


        }
    }

    public function supprimerEnCours($IDserie)
    {
        $user = unserialize($_SESSION['user']);
        $userId = $user->IDuser;
        if (self::enCours($IDserie, $userId)) {
            $query = "DELETE FROM enCours WHERE IDserie = ?";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute([$IDserie]);
        }
    }

}