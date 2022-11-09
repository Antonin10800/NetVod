<?php

namespace netvod\video\Etat;

use netvod\auth\Auth;

class EnCours
{
    /**
     * Serie en cours de visionnage
     */


    public function enCours($IDserie): bool
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

    public function ajouterEnCours($IDserie)
    {
        if (!$this->enCours()) {
            $query = "INSERT INTO enCours (IDserie) VALUES (?,?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $user = unserialize($_SESSION['user']);
            $stmt->execute($user,[$IDserie]);
        }
    }

    public function supprimerEnCours($IDserie)
    {
        if ($this->enCours()) {
            $query = "DELETE FROM enCours WHERE IDuser = ? AND IDserie = ?";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $user = unserialize($_SESSION['user']);
            $stmt->execute($user,[$IDserie]);
        }
    }

}