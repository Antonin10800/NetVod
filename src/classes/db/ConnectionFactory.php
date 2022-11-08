<?php

namespace netvod\db;

use PDO;

class ConnectionFactory
{

    private static $db;
    private static $config = [];

    public static function setConfig(): void
    {
        self::$config = parse_ini_file("db.config.ini");
    }

    public static function makeConnection() : PDO
    {
        if (self::$db == null)
        {
            if(self::$config !=null) {
                $database = new PDO('mysql:host=' . self::$config['host'] . ';dbname=' . self::$config['database'],
                    self::$config['username'],
                    self::$config['password'], [
                        PDO::ATTR_PERSISTENT => true,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_STRINGIFY_FETCHES => false,
                    ]);

                self::$db = $database;

                self::$db->prepare('SET NAMES \'UTF8\'')->execute();
            }
        }
        return self::$db;
    }

}