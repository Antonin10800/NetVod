<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use netvod\db\ConnectionFactory;
use netvod\render\ListeSerieRender;
use netvod\video\lists\ListeSerie;

ConnectionFactory::setConfig();


$series = new ListeSerie();
$series = $series->getSeries();
$render = new ListeSerieRender($series);
echo $render->render();
