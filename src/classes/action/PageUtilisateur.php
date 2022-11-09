<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\video\lists\ListeSerie;

class PageUtilisateur implements Action {

    public function execute(): string {

        $db = ConnectionFactory::makeConnection();
        $user = unserialize($_SESSION['user']);
        $idUser = $user->IDuser;

        $query = $db->prepare("select IDSerie from Favoris where IDUser = ?");
        $query->bindParam(1, $idUser);
        $query->execute();

        $html = "";
        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();
        while($data = $query->fetch()){
            $serieFav = $series[$data["IDSerie"]-1];
            echo $serieFav->titre;
        }

        return $html;


    }

}
