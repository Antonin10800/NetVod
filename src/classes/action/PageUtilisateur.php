<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;

class PageUtilisateur implements Action {

    public function execute(): string {

        $db = ConnectionFactory::makeConnection();
        $user = unserialize($_SESSION['user']);
        $idUser = $user->IDuser;

        $query = $db->prepare("select IDSerie from Favoris where IDUser = ?");
        $query->bindParam(1, $idUser);
        $query->execute();

        $html = "";
        while($data = $query->fetch()){
            // afficher la photo de chaque serie
        }

        return $html;


    }

}
