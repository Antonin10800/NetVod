<?php

namespace netvod\Auth;

use netvod\db\ConnectionFactory;
use PDO;
use netvod\user\Utilisateur;

class Auth {

    public static function authenticate(string $email, string $passwd2check) : ?Utilisateur { // retourne un User ou null
        $db = ConnectionFactory::makeConnection();
        $query = $db->prepare("select passwd, role from User where email = ?;");
        $query->bindParam(1, $email);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $hash = $row['passwd'];
        $role = $row['role'];
        if (!password_verify($passwd2check, $hash)) return null;
        return new User($role, $email, $hash);
    }

    public static function register( string $email, string $pass) {
        if(strlen($pass) < 10) throw new \Exception('mot de passe trop court');

        $db = ConnectionFactory::makeConnection();
        $sql = "select * from user where email = ?;";
        $query = $db->prepare($sql);
        $query->bindParam(1, $email);
        $query->execute();
        if($query->fetch()) throw new \Exception("Compte deja existant");

        // encode le mot de passe
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);

        // inserer l'utilisateur
        $sql = "insert into User set email = ?, passwd=?;";
        $query = $db->prepare($sql);
        $query->bindParam(1, $email);
        $query->bindParam(2, $hash);
        $query->execute();
    }

    public static function checkAccessLevel(int $require) : void {
        $userLevel = (int)(unserialize($_SESSION['user'])->role);
        if($userLevel < $require) throw new \Exception("Acces refuse");
    }

    public static function checkPlaylistOwner(int $playlist) : void {
        if(!isset($_SESSION['user'])) throw new \Exception("Acces refuse");
        $user = unserialize($_SESSION['user']);
        if($user->role === User::ADMIN_USER) return;

        $query = 'select * from user, user2playlist where email = ? and user.id = user2playlist.user_id and user2playlist.id_pl = ?;';
        $db = ConnectionFactory::makeConnection();

        $stmt = $db->prepare($query);
        $res = $stmt->execute([$user->email, $playlist]);
        if(!$res) throw new \Exception("Erreur requete");

        $row = $stmt->fetch();
        if(!$row) throw new \Exception("Acces refuse");
    }

}