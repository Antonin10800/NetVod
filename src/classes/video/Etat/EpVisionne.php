<?php

namespace netvod\video\Etat;
use netvod\db\ConnectionFactory;
class EpVisionne
{
    public static function Visionne($IDUser,$IDEpisode): bool
    {
        $query = "SELECT * FROM EpVisionne WHERE IDUser = ? and $IDEpisode = ?";
        $db = ConnectionFactory::makeConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$IDUser,$IDEpisode]);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function ajouterVisionne($IDUser,$IDEpisode)
    {
        if (!self::Visionne($IDUser,$IDEpisode)) {
            $query = "INSERT INTO EpVisionne (IDUser,iDEpisode) VALUES (?,?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->bindParam(1,$IDUser);
            $stmt->bindParam(2,$IDEpisode);
            $stmt->execute();
        }
    }


}