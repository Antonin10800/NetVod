<?php

require_once 'classes/db/ConnectionFactory.php';
require_once 'classes/Date.php';
netvod\db\ConnectionFactory::setConfig();
$db = netvod\db\ConnectionFactory::makeConnection();

if($db === null)
{
    echo "Erreur de connexion à la base de données";
    exit;
}
