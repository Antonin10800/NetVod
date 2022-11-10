<?php

namespace netvod\action;

use netvod\video\lists\ListeSerie;
use netvod\db\ConnectionFactory;

/**
 * class Commentaire
 * qui permet de gerer les commentaires
 */
class Commentaire implements Action {

    /**
     * fonction execute qui permet d'executer l'action
     */
    public function execute(): string {

        $html = '';
        $idSerie = $_GET['idSerie'];
        $moy = 0;

        // si la requte est de type get on affiche le formulaire pour ajouter un commentaire
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

            $listeSerie = ListeSerie::getInstance();

            $utilisateur = unserialize($_SESSION['user'])->IDuser;
            $note = filter_var($_POST['note'],FILTER_SANITIZE_NUMBER_FLOAT);
            $commentaire = filter_var($_POST['commentaire'],FILTER_SANITIZE_STRING);

            foreach ($listeSerie->getSeries() as $serie) {
                if($serie->IDserie == $idSerie){
                    $avis = $serie->getAvis();
                    break;
                }
            }
            $dejaCommente = false;
            foreach ($avis as $a) {
                if($a->idUser == $utilisateur->IDuser){
                    $dejaCommente = true;
                    break;
                }
            }

            if(!$dejaCommente){
                $db = ConnectionFactory::makeConnection();
                $req = $db->prepare("INSERT INTO `Avis` (`IDUser`, `IDSerie`, `commentaire`, `note`) VALUES (?, ?, ?, ?);");
                $req->bindParam(1, $utilisateur);
                $req->bindParam(2, $idSerie);
                $req->bindParam(3, $commentaire);
                $req->bindParam(4, $note);
                $req->execute();
                $req->closeCursor();
                $listeSerie->actualiserAvis();
            }else{
                $html .= "Vous avez déjà commenté cette série";
            }
        }

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

        if(count($avis) == 0 ){
            $html .= 'Aucun commentaire';
        }else{
            $moy = $moy / count($avis);
            $html .= "Moyenne : " . $moy;
        }

        return $html;
    }

}


