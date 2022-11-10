<?php

namespace netvod\video\Etat;

use netvod\db\ConnectionFactory;
use netvod\user\Utilisateur;
use netvod\video\lists\ListeSerie;

class EnCours
{
    /**
     * fonction qui vérifie si une série est en cours pour un utilisateur
     * @param int $IDserie
     * @param int $IDuser
     * @return bool
     */
    public static function enCours(int $IDserie, int $IDuser): bool
    {
        //connexion a la bd
        $db = ConnectionFactory::makeConnection();
        $query = "SELECT * FROM enCours WHERE IDUser = ? AND IDserie =?";
        $statement = $db->prepare($query);
        $statement->bindParam(1,$IDuser);
        $statement->bindParam(2,$IDserie);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        if($data ===false)
        {
            return true;
        }
        return false;
    }

    /**
     * méthode qui permet d'ajouter dans la table enCours
     * @param $IDserie série
     * @return void
     */
    public static function ajouterEnCours(int $IDserie, int $idUser):void
    {
        $db = ConnectionFactory::makeConnection();
        $query = "INSERT INTO enCours VALUES (?,?)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $idUser);
        $stmt->bindParam(2, $IDserie);
        $stmt->execute();
    }

    /**
     * fonction qui supprime une série
     * @param $IDserie série
     * @return void
     */
    public static function supprimerEnCours(int $IDserie)
    {
        $utilisateur = unserialize($_SESSION['user']);
        $idUser = $utilisateur->IDuser;
        $db = ConnectionFactory::makeConnection();
        if (!self::enCours($IDserie, $idUser)) {
            $query = "DELETE FROM enCours WHERE IDserie = ?";

            $stmt = $db->prepare($query);
            $stmt->bindParam(1,$IDserie);
            $stmt->execute();
        }
    }

    public static function remplirEnCours(Utilisateur $user): Utilisateur
    {
        //on récupere l'id User
        $idUser = $user->IDuser;
        //on recupere les favoris de l'utilisateur
        $query = "SELECT * FROM enCours WHERE IDUser = ?";
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
                if($a->IDserie == $item['IDserie']){
                    $serie = $a;
                    break;
                }
            }
            $user->ajouterEnCours($serie);
        }
        return $user;
    }

}