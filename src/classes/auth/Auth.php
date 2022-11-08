<?php

namespace netvod\Auth;

use netvod\db\ConnectionFactory;
use PDO;
use netvod\user\Utilisateur;

class Auth
{

    public static function authenticate(string $email, string $passwd2check): ?Utilisateur
    {
        $db = ConnectionFactory::makeConnection();
        $query = $db->prepare("select * from Utilisateur where email = ?;");
        $query->bindParam(1, $email);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $id = $row['IDUser'];
        $hash = $row['motDePasse'];
        $role = $row['role'];
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        $sexe = $row['sexe'];
        if (!password_verify($passwd2check, $hash)) return null;
        return new Utilisateur($id, $email, $hash, $nom, $prenom, $role, $sexe);
    }

    public static function register(string $email, string $pass, string $nom, string $prenom)
    {
        if (strlen($pass) < 10) throw new \Exception('mot de passe trop court');

        $db = ConnectionFactory::makeConnection();
        $sql = "select * from Utilisateur where email = ?;";
        $query = $db->prepare($sql);
        $query->bindParam(1, $email);
        $query->execute();
        if ($query->fetch()) throw new \Exception("Compte deja existant");

        // encode le mot de passe
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);

        // inserer l'utilisateur
        $sql = "insert into Utilisateur set email = ?, motDePasse=?, role=1, nom=?, prenom=?;";
        $query = $db->prepare($sql);
        $query->bindParam(1, $email);
        $query->bindParam(2, $hash);
        $query->bindParam(3, $nom);
        $query->bindParam(4, $prenom);
        $query->execute();
    }
}