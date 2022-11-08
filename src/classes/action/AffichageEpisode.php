<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\EpisodeRender;
use netvod\video\episode\Episode;

class AffichageEpisode
{
    public function execute(int $episode): string
    {
        $db = ConnectionFactory::makeConnection();
        $query = $db->prepare("select * from Episode where idEpisode = ?;");
        $query->bindParam(1, $episode);
        $query->execute();
        $row = $query->fetch();

        $render = new EpisodeRender(new Episode($row['idEpisode'],$row['duree'],$row['titre'],$row['image'],$row['numEp']));
        return $render->render();
    }
}