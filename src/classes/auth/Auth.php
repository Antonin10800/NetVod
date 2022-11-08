<?php

namespace netvod\Auth;

use netvod\db\ConnectionFactory;
use PDO;
use netvod\user\Utilisateur;

class Auth
{

    public static function authenticate(string $email, string $passwd2check): ?Utilisateur
    { // retourne un User ou null
        $db = ConnectionFactory::makeConnection();
        $query = $db->prepare("select passwd, role from User where email = ?;");
        $query->bindParam(1, $email);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $hash = $row['passwd'];
        $role = $row['role'];
        if (!password_verify($passwd2check, $hash)) return null;
        return new Utilisateur($role, $email, $hash);
    }

    public static function register(string $email, string $pass)
    {
        if (strlen($pass) < 10) throw new \Exception('mot de passe trop court');

        $db = ConnectionFactory::makeConnection();
        $sql = "select * from user where email = ?;";
        $query = $db->prepare($sql);
        $query->bindParam(1, $email);
        $query->execute();
        if ($query->fetch()) throw new \Exception("Compte deja existant");

        // encode le mot de passe
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);

        // inserer l'utilisateur
        $sql = "insert into User set email = ?, passwd=?;";
        $query = $db->prepare($sql);
        $query->bindParam(1, $email);
        $query->bindParam(2, $hash);
        $query->execute();
    }
}