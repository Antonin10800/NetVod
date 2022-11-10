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

        $res = '<!DOCTYPE html>';
        $res .= '<html lang="fr"> <head>';
        $res .= '<meta charset="UTF-8">';
        $res .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $res .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $res .= '<title>NetVod</title>';
        $res .= '<link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>';
        $res .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
        $res .= '<link rel="stylesheet" href="src/css/commentaire.css">';
        $res .= '</head><body>';

        $res .= <<<END
            <header>
                <div class="headerLeft">
                    <a href="?action=lobby">NETVOD</a>
                </div>
            </header>
        END;


        $idSerie = $_GET['idSerie'];
        $moy = 0;

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $res .= <<<END
                <div class="bottom-main">
                    <div class="title-main">
                        <h1>Commentaire</h1>
                    </div>
                    <div class="note">
                        <form method="post" action="?action=commentaires&idSerie=$idSerie">
                            <dive class="valeur-note">
                                <input type="radio" name="note" value=1>1
                                <input type="radio" name="note" value=2>2
                                <input type="radio" name="note" value=3>3
                                <input type="radio" name="note" value=4>4
                                <input type="radio" name="note" value=5>5
                            </div>
                            <div class="commentaire">
                                <input type="commentaire" name="commentaire">
                                <button type="submit"><i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
            END;
        } else if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $db = ConnectionFactory::makeConnection();

            $utilisateur = unserialize($_SESSION['user'])->IDuser;
            $note = filter_var($_POST['note'],FILTER_SANITIZE_NUMBER_FLOAT);
            $commentaire = filter_var($_POST['commentaire'],FILTER_SANITIZE_STRING);

            $req = $db->prepare("SELECT * FROM Avis where IDserie = ?");
            $req->execute([$idSerie]);
            $count = $req->rowCount();

            if($count == 0){
                $req = $db->prepare("INSERT INTO `Avis` (`IDUser`, `IDSerie`, `commentaire`, `note`) VALUES (?, ?, ?, ?);");
                $req->bindParam(1, $utilisateur);
                $req->bindParam(2, $idSerie);
                $req->bindParam(3, $commentaire);
                $req->bindParam(4, $note);
                $req->execute();
            }else{
                $res .= "Vous avez déjà commenté cette série";
            }
        }

        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();
        $serieEnCour = $series[$idSerie-1];
        $avis = $serieEnCour->avis;
        $res .= "<div class=\"espaces-com\">";
        foreach ($avis as $avi){
            $res .= <<<END
                <div class="com">
                    <div class="leftCom">
                        <h1>Nom : {$avi->nomUtilisateur}</h1>
                        <div class="hr">
                        </div>
                        <p> Commentaire : {$avi->commentaire}</p>
                    </div>
                    <h1 id="note"> Note : {$avi->note}</p>
                </div>
            END;
            $moy += $avi->note;
        }
        $res .= "</div>";

        if(count($avis) == 0 ){
            $res .= 'Aucun commentaire';
        }else{
            $moy = $moy / count($avis);
            $res .= "Moyenne : " . $moy;
        }

        $res .= '</div></body></html>';
        return $res;
    }
}