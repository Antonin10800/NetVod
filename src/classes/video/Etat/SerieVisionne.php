<?php

namespace netvod\video\Etat;
use netvod\auth\Auth;
use netvod\db\ConnectionFactory;
use netvod\user\Utilisateur;
use netvod\video\lists\ListeSerie;

class SerieVisionne
{
    /**
     * méthode qui permet de vérifier si une série est visionné
     * @param $IDUser id de l'user
     * @param $IDSerie id de la série
     * @return bool résultat
     */
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

    /**
     * méthode qui permet d'ajouter une série dans celle qui sont deja visionne
     * @param $IDUser id de l'user
     * @param $IDSerie id de la série
     * @return void
     */
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

    /**
     * méthode qui permet de remplir le tableau de visionne
     * @param Utilisateur $user
     * @return Utilisateur
     */
    public static function remplirVisionner(Utilisateur $user): Utilisateur
    {
        //on récupere l'id User
        $idUser = $user->IDuser;
        //on recupere les favoris de l'utilisateur
        $query = "SELECT * FROM SerieVisionne WHERE IDUser = ?";
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare($query);
        $statement->bindParam(1,$idUser);
        $statement->execute();
        //on recupere les séries :
        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();
        //on fetch les favoris
        $row = $statement->fetchAll();
        foreach ($row as $item)
        {
            foreach ($series as $a) {
                if($a->IDserie == $item['IDSerie']){
                    $serie = $a;
                    break;
                }
            }
            $user->ajouterVisionne($serie);
        }
        return $user;
    }
}
