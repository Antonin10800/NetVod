<?php

namespace netvod\video\Etat;
use netvod\auth\Auth;
use netvod\db\ConnectionFactory;
class SerieVisionne
{
    public static function Visionne($IDUser, $IDSerie): bool
    {
        //on selection dans la bd
        $query = "SELECT * FROM SerieVisionne WHERE IDUser = ? AND IDSerie = ?";
        $db = ConnectionFactory::makeConnection();

        $stmt = $db->prepare($query);
        $stmt->bindParam(1,$IDUser);
        $stmt->bindParam(2,$IDSerie);
        $stmt->execute();
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
            $stmt->bindParam(1,$IDUser);
            $stmt->bindParam(2,$IDSerie);
            $stmt->execute();
        }
    }
}
