<?php

namespace Core\Database;

use PDO;
use Core\Database\DatabaseConfigInterface;
//Design pattern Singleton
class Database
{
    private const PDO_OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    private static ?PDO $pdoInstance = null;

    public static function getPDO(DatabaseConfigInterface $config)
    {
        if (is_null(self::$pdoInstance)) {
            $dsn = sprintf('mysql:dbname=%s;host=%s', $config->getName(), $config->getHost());

            self::$pdoInstance = new PDO($dsn, $config->getUser(), $config->getPass(), self::PDO_OPTIONS);
        }

        return self::$pdoInstance;
    }

    //on doit passer le constructeur en private pour empecher l'instanciation de la classe
    private function __construct(){}
    //on passe la méthode clone en private pour empecher le clonage de la classe
    private function __clone(){}

    public function __wakeup(){}
}
