<?php

namespace netvod\action;

use netvod\Auth\Auth;
use netvod\db\ConnectionFactory;
use netvod\user\Utilisateur;
use netvod\video\episode\Serie;

class Favoris implements Action
{
    public function execute(): string
    {

        $html = "";
        //on récupere l'utilisateur
        $utilisateur = unserialize($_SESSION['user']);
        //on récupere l'id User et l'id Serie
        $idUser = $utilisateur->IDuser;
        $idSerie = filter_var($_GET['idSerie'],FILTER_SANITIZE_NUMBER_INT);
        $serie = Serie::getSerie($idSerie);
        //on vérifie si la série est deja en favoris
        if(self::pasDeFavoris())
        {
            $query = "INSERT INTO Favoris VALUES(?,?)";

            $utilisateur->ajouterFavoris($serie);
            $_SESSION['user'] = serialize($utilisateur);
        }
        else
        {
            $query = "DELETE FROM Favoris WHERE IDUser = ? AND IDSerie= ?";
            $utilisateur->supprimerFavoris($serie);
            $_SESSION['user'] = serialize($utilisateur);
        }
        echo "<pre>";
        var_dump($utilisateur);
        //on redirige vers notre série:
        //on execute la query
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare($query);
        $statement->bindParam(1,$idUser);
        $statement->bindParam(2,$idSerie);
        $statement->execute();
        //header('Location: ?action=afficher-serie&idSerie=' . $idSerie);
        return $html;
    }

    public static function pasDeFavoris():bool
    {
        //on récupere l'utilisateur
        $utilisateur = unserialize($_SESSION['user']);
        //on récupere l'id de l'utilisateur
        $idUser = $utilisateur->IDuser;
        //on récupere l'id de la série dans le lien GET:
        $idSerie = filter_var($_GET['idSerie'], FILTER_SANITIZE_NUMBER_INT);

        //on select dans favoris:
        $query = "SELECT * FROM Favoris WHERE IDUser = ? AND IDSerie = ?";
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare($query);
        $statement->bindParam(1,$idUser);
        $statement->bindParam(2,$idSerie);
        $statement->execute();
        //si row === false alors la requete n'est pas dans la BD.
        $row = $statement->fetch();
        if($row === false)
        {
            //retourne vrai si n'est pas dans la bd
            return true;
        }
        //sinon retourne false
        return false;
    }

    public static function remplirFavoris(Utilisateur $user): Utilisateur
    {
        $idUser = $user->IDuser;
        $query = "SELECT * FROM Favoris WHERE IDUser = ?";
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare($query);
        $statement->bindParam(1,$idUser);
        $statement->execute();
        $row = $statement->fetchAll();
        foreach ($row as $item)
        {
            $serie = Serie::getSerie($item['IDSerie']);
            $user->ajouterFavoris($serie);
        }
        return $user;
    }
}