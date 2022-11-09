<?php

namespace netvod\action;

use netvod\video\lists\ListeSerie;

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

        return $html;
    }






}


