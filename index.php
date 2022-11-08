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

//$user = unserialize($_SESSION['user']);

echo $html;