<?php

namespace netvod\action;

use netvod\action\Action;
use netvod\video\episode\Episode;
use netvod\db\ConnectionFactory;
use netvod\render\RenderInfoSerie;

use netvod\video\episode\Serie;
use netvod\video\lists\ListeSerie;

class AfficherSerie implements Action
{

    private Serie $serieCourante;

    public function execute(): string
    {

        //on charge les épisode de la série:
        $this->chargerEpisode();

        //on crée un série render Info:
        $serieRender = new RenderInfoSerie($this->serieCourante);
        $html = $serieRender->render();

        return $html;
    }


    public function chargerEpisode()
    {
        //on récupere l'id série
        $html = '';
        $idSerie = filter_var($_GET['idSerie'], FILTER_SANITIZE_NUMBER_INT);

        //on récupere la liste des séries:
        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();

        //on parcours toute les séries
        foreach ($series as $s) {
            //si l'id de la série est égal a la l'id série du GET:
            if ($s->IDserie == $idSerie) {
                //on mets la série trouve dans une variable
                $serieTrouve = $s;
                //on trouve la série qu'on cherche
                $this->serieCourante = $serieTrouve;
                //on s'arrete
                break;
            }
        }
        if ($this->serieCourante->listeEpisode == null) {
            //si la série a une liste null:
            if ($this->serieCourante->listeEpisode == null) {
                //on récupére

                $db = ConnectionFactory::makeConnection();

                $query = "select E.idEpisode, titre, duree, image,numEp from Serie2Episode inner join 
                            Episode E on Serie2Episode.IDEpisode = E.idEpisode
                            where Serie2Episode.IDSerie = ?";
                $stmt = $db->prepare($query);
                $stmt->execute([$idSerie]);
                $result = $stmt->fetchAll();
                $listeEpisode = array();
                foreach ($result as $row) {
                    $episode = new Episode($row['idEpisode'], $row['duree'], $row['titre'], $row['image'], $row['numEp']);
                    $listeEpisode[] = $episode;
                }
                $this->serieCourante->listeEpisode = $listeEpisode;


                $stmt = $db->prepare($query);
                $stmt->execute([$idSerie]);
                $result = $stmt->fetchAll();
                $listeEpisode = array();
                foreach ($result as $row) {
                    $episode = new Episode($row['idEpisode'], $row['duree'], $row['titre'], $row['image'], $row['numEp']);
                    $listeEpisode[] = $episode;
                }
                $this->serieCourante->__set('listeEpisode', $listeEpisode);

            }
        }


    }
}


