<?php

namespace netvod\video\Etat;

class EpVisionne
{
    public function Visionne($IDUser,$IDEpisode): bool
    {
        $query = "SELECT * FROM EpVisionne WHERE IDUser = ? and $idEpisode = ?";
        $db = ConnectionFactory::makeConnection();
        $stmt = $db->prepare($query);
        $stmt->execute($IDUser,$IDEpisode);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ajouterVisionne($IDUser,$IDEpisode)
    {
        if (!self::Visionne()) {
            $query = "INSERT INTO EpVisionne (IDUser,idEpisode) VALUES (?,?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute($IDUser,$IDEpisode);
        }
    }


}