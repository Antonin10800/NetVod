<?php

namespace netvod\Auth;

use netvod\db\ConnectionFactory;
use PDO;
use netvod\user\Utilisateur;

class Auth
{

    public static function authentificate(string $email, string $passwd2check): ?Utilisateur
    {

            $db = ConnectionFactory::makeConnection();
            $query = $db->prepare("select * from Utilisateur where email = ?;");
            $query->bindParam(1, $email);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if($row === null)
            {
                return null;
            }
            else {
                $id = $row['IDUser'];
                $hash = $row['motDePasse'];
                $role = $row['role'];
                $nom = $row['nom'];
                $prenom = $row['prenom'];
                $sexe = $row['sexe'];
                if (!password_verify($passwd2check, $hash)) return null;
            }
            return new Utilisateur($id, $email, $hash, $nom, $prenom, $role, $sexe);

    }

    public static function register(string $email, string $pass, string $nom, string $prenom, string $sexe): int
    {
        if (strlen($pass) < 10) return -1;

        // encode le mot de passe
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $db = ConnectionFactory::makeConnection();
            $sql = "select count(email) from Utilisateur where email = ?;";
            $query = $db->prepare($sql);
            $query->bindParam(1, $email);
            $query->execute();
            $result = $query->fetch();
            if($result[0] == 0)
            {
                $sql = "insert into Utilisateur values (NEXT VALUE FOR seqUser, ?, ?, 1, ?, ?, ?);";
                $query = $db->prepare($sql);
                $query->bindParam(1, $email);
                $query->bindParam(2, $hash);
                $query->bindParam(3, $nom);
                $query->bindParam(4, $prenom);
                $query->bindParam(5, $sexe);
                $query->execute();
                $query->closeCursor();
                return 1;
            }
            else
            {
                return 0;
            }
        }
        return 0;

    }
    public static function verification():bool
    {
        if(isset($_SESSION['user'])) return true;
        return false;
    }
}