<?php

namespace netvod\action;

use netvod\user\Utilisateur;
use netvod\video\episode\Serie;
use netvod\video\lists\ListeSerie;
use netvod\db\ConnectionFactory;

/**
 * class Commentaire
 * qui permet de gerer les commentaires
 */
class Commentaire implements Action
{


    /**
     * fonction execute qui permet d'executer l'action
     */
    public function execute(): string
    {
        $res = self::header();

        $listeSerie = ListeSerie::getInstance();
        $tabSeries = $listeSerie->getSeries();

        $serie = Serie::trouverSerie($tabSeries, $_GET['idSerie']);
        $utilisateur = unserialize($_SESSION['user']);
        $idUser = $utilisateur->IDuser;


        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(!$this->commentaireExiste($serie, $idUser))
            {
                $res .= self::lorsGet($_GET['idSerie']);
            }

            $res .= self::afficherComm($serie);

        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {



            $note = filter_var($_POST['note'], FILTER_SANITIZE_NUMBER_FLOAT);
            $commentaire = filter_var($_POST['commentaire'], FILTER_SANITIZE_STRING);



            if(!$this->commentaireExiste($serie, $idUser))
            {
                $this->insererCommentaire($serie, $idUser, $commentaire, $note);
            }

            $res .= $this->afficherComm($serie);



        }

        return $res;
    }


    public function lorsGet($idSerie): string
    {
        $res = '';
        $res .= <<<END
                    <div class="note">
                        <form method="post" action="?action=commentaires&idSerie=$idSerie">
                            <div class="valeur-note">
                                <a onclick="star1()"><i id="star1" class="fa-solid fa-star"></i></a>
                                <a onclick="star2()"><i id="star2" class="fa-solid fa-star"></i></a>
                                <a onclick="star3()"><i id="star3" class="fa-solid fa-star"></i></a>
                                <a onclick="star4()"><i id="star4" class="fa-solid fa-star"></i></a>
                                <a onclick="star5()"><i id="star5" class="fa-solid fa-star"></i></a>
                                
                                <input id="valeurnote" type="hidden" name="note" id="note" value="0">
                            </div>
                            <div class="commentaire">
                                <input type="commentaire" name="commentaire">
                                <button type="submit"><i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </form>
            END;
        return $res;
    }

    public function header(): string
    {
        $res = '<!DOCTYPE html>';
        $res .= '<html lang="fr"> <head>';
        $res .= '<meta charset="UTF-8">';
        $res .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $res .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $res .= '<title>NetVod</title>';
        $res .= '<script src="src/js/profile.js"></script>';
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

        $res .= <<<END
            <div class="bottom-main">
                <div class="title-main">
                    <h1>Commentaire</h1>
                </div>
        END;
        return $res;
    }

    public function insererCommentaire(Serie $serie, $idUser, $commentaire, $note)
    {

        $avis = $serie->getAvis();


        $present = false;
        foreach ($avis as $a) {
            if ($a->idSerie == $serie->IDserie) {
                $present = true;
                if (!($a->idUser == $idUser)) {
                    $this->inserer($idUser, $a->idSerie, $commentaire, $note);
                    break;
                }
            }
        }

        if(!$present)
        {
            $this->inserer($idUser, $serie->IDserie, $commentaire, $note);
        }
        $listeSerie = ListeSerie::getInstance();
        $listeSerie->actualiserAvis();
    }

    public function commentaireExiste(Serie $serie, $idUser):bool
    {
        $avis = $serie->getAvis();
        foreach($avis as $a)
        {
            if($a->idSerie == $serie->IDserie)
            {
                if($a->idUser == $idUser)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function inserer($idUser, $a, $commentaire, $note)
    {
        $db = ConnectionFactory::makeConnection();

        $req = $db->prepare("INSERT INTO `Avis` (`IDUser`, `IDSerie`, `commentaire`, `note`) VALUES (?, ?, ?, ?);");
        $req->bindParam(1, $idUser);
        $req->bindParam(2, $a);
        $req->bindParam(3, $commentaire);
        $req->bindParam(4, $note);
        $req->execute();
        $req->closeCursor();
    }

    public function afficherComm($serie):string
    {

        $res = "<div class=\"espaces-com\">";

        $moy = 0;
        foreach ($serie->getAvis() as $avi) {
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

        $res .= '</div></body></html>';
        return $res;
    }
}