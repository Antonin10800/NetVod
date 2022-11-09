<?php

namespace netvod\video\Etat;

class SerieVisionne
{
    public static function Visionne($IDUser,$IDserie): bool
    {
        $query = "SELECT * FROM SerieVisionne WHERE IDUser = ? and $idSerie = ?";
        $db = ConnectionFactory::makeConnection();
        $stmt = $db->prepare($query);
        $stmt->execute($IDUser,$IDserie);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function ajouterVisionne($IDUser,$IDserie)
    {
        if (!self::Visionne()) {
            $query = "INSERT INTO SerieVisionne (IDUser,idSerie) VALUES (?,?)";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute($IDUser,$IDserie);
        }
    }

