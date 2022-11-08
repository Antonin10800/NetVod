<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use netvod\db\ConnectionFactory;
use netvod\dispatch\Dispatcher;

ConnectionFactory::setConfig();

if (isset($_SESSION['utilisateur'])) {

}
else
{
    $_SESSION['utilisateur'] = null;
}

$html = '';
$dispatch = new Dispatcher();
$html .= $dispatch->dispatch();

echo $html;