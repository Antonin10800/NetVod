<?php

namespace netvod\video\Etat;

namespace netvod\auth\Auth;

class EnCours
{
    /**
     * Serie en cours de visionnage
     */

    public function __construct($IDserie)
    {
        $this->IDserie = $IDserie;
    }

    public function enCours(): bool
    {
        $query = "SELECT * FROM enCours WHERE IDserie = ?";
        $db = ConnectionFactory::makeConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$this->IDserie]);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ajouterEnCours()
    {
        if (!$this->enCours()) {
            $query = "INSERT INTO enCours (IDserie) VALUES (?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute([$this->IDserie]);
        }
    }

    public function supprimerEnCours()
    {
        if ($this->enCours()) {
            $query = "DELETE FROM enCours WHERE IDserie = ?";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute([$this->IDserie]);
        }
    }

}