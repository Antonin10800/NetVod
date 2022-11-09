<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use netvod\db\ConnectionFactory;
use netvod\dispatch\Dispatcher;

session_start();

ConnectionFactory::setConfig();

$html = '';
$dispatch = new Dispatcher();
$html .= $dispatch->dispatch();

<<<<<<< HEAD

=======
//$user = unserialize($_SESSION['user']);

/* permet de tester la fonctionnalité 5 pour le moment
$html .= '<a href="?action=afficher-episode&IDepisode=1">Ep1</a>';
$html .= '<a href="?action=afficher-episode&IDepisode=2">Ep2</a>';
$html .= '<a href="?action=afficher-episode&IDepisode=3">Ep3</a>';
*/
>>>>>>> 75fcc81599b6eee9aa4d10aa8d546fb8bc73bf0c

echo $html;