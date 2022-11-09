<?php

namespace netvod\video\Etat;
use netvod\auth\Auth;
use netvod\db\ConnectionFactory;
class SerieVisionne
{
    public static function Visionne($IDUser, $IDSerie): bool
    {
        $query = "SELECT * FROM SerieVisionne WHERE IDUser = ? and $IDSerie = ?";
        $db = ConnectionFactory::makeConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$IDUser, $IDSerie]);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function ajouterVisionne($IDUser, $IDSerie)
    {
        if (!self::Visionne($IDUser, $IDSerie)) {
            $query = "INSERT INTO SerieVisionne (IDUser,IDSerie) VALUES (?,?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute([$IDUser, $IDSerie]);
        }
    }
}
