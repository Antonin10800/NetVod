<?php

namespace netvod\action;

use Action;
use netvod\db\ConnectionFactory;
use netvod\render\SerieRender;
use netvod\video\episode\Serie;

class AfficherSerie implements Action
{

    private Serie $serieCourante;

    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //TODO
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST'))
        {
            $this->chargerEpisode();
            //TODO

            $serieRender = new SerieRender($this->serieCourante);
            $html = $serieRender->render();


        }

        return $html;
    }


    public function chargerEpisode()
    {
        $html = '';
        $idSerie = filter_var($_POST['idSerie'],FILTER_SANITIZE_NUMBER_INT);

        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();

        foreach ($series as $s) {
            if ($s->__get('IDserie') == $idSerie)
            {
                $serieTrouve = $s;
                $this->serieCourante = $serieTrouve;
                break;
            }
        }
        if ($serieTrouve->__get('listeEpisode') == null) {
            $query = "select E.idEpisode, titre, duree, image,numEp from Serie2Episode inner join 
                            Episode E on Serie2Episode.IDEpisode = E.idEpisode
                            where Serie2Episode.IDSerie = ?";
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare($query);
            $stmt->execute([$idSerie]);
            $result = $stmt->fetchAll();
            $listeEpisode = array();
            foreach ($result as $row) {
                $episode = new Episode($row['idEpisode'], $row['titre'], $row['duree'], $row['image'], $row['numEp']);
                $listeEpisode[] = $episode;
            }
            $serieTrouve->__set('listeEpisode', $listeEpisode);

        }
    }



}


