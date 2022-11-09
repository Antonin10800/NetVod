<?php

namespace netvod\action;

use netvod\video\lists\ListeSerie;
use netvod\db\ConnectionFactory;

class Commentaire implements Action {

    public function execute(): string {

        $html = '';
        $idSerie = $_GET['idSerie'];
        $moy = 0;

        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();
        $serieEnCour = $series[$idSerie-1];
        $avis = $serieEnCour->avis;
        foreach ($avis as $avi){
            $html .= <<<END
                <div><p>
                Nom : {$avi->nomUtilisateur}<br>
                Commentaire : {$avi->commentaire}<br>
                Note : {$avi->note}<br>
                </p></div>
            END;
            $moy += $avi->note;
        }

        if($html == ''){
            $html = 'Aucun commentaire';
        }else{
            $moy = $moy / count($avis);
            $html .= "Moyenne : " . $moy;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $html .= <<<END
                <form method="post" action="?action=commentaires&idSerie=$idSerie">
                <input type="radio" name="note" value=1>1
                <input type="radio" name="note" value=2>2
                <input type="radio" name="note" value=3>3
                <input type="radio" name="note" value=4>4
                <input type="radio" name="note" value=5>5
                <input type="commentaire" name="commentaire"  placeholder="commentaire">
                <button type="submit">ajouter</button></form>
            END;
        } else if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $utilisateur = unserialize($_SESSION['user'])->IDuser;
            $note = filter_var($_POST['note'],FILTER_SANITIZE_NUMBER_FLOAT);
            $commentaire = filter_var($_POST['commentaire'],FILTER_SANITIZE_STRING);

            $db = ConnectionFactory::makeConnection();
            $req = $db->prepare("INSERT INTO `Avis` (`IDUser`, `IDSerie`, `commentaire`, `note`) VALUES ('?', '?', '?', '?');");
            $req->bindParam(1, $utilisateur);
            $req->bindParam(2, $idSerie);
            $req->bindParam(3, $commentaire);
            $req->bindParam(4, $note);
            $req->execute();
        }

        return $html;
    }






}


