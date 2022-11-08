<?php

require_once 'classes/db/ConnectionFactory.php';
\iutnc\deefy\db\ConnectionFactory::setConfig();
$db = \iutnc\deefy\db\ConnectionFactory::makeConnection();

if($db === null)
{
    echo "Erreur de connexion à la base de données";
    exit;
}
