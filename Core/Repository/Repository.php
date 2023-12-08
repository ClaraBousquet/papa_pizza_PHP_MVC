<?php

namespace Core\Repository;

use PDO;
use Core\Database\Database;
use Core\Database\DatabaseConfigInterface;

abstract class Repository
{
    protected PDO $pdo;

    abstract public function getTableName(): string;

    public function __construct(DatabaseConfigInterface $config)
    {
        $this->pdo = Database::getPDO($config);
    }

    //méthode qui permet de récupérer tous les éléments d'une table
    public function readAll(string $class_name)
    {
        $array_result = [];
        //déclarer notre requete
        $q = sprintf('SELECT * FROM %s', $this->getTableName());
        //on execute la requete
        $stmt = $this->pdo->query($q);
        //on vérifie si la requete a fonctionné
        if (!$stmt) return $array_result;

        //on récupère les données
        while ($row_data = $stmt->fetch()) {
            $array_result[] = new $class_name($row_data);
        }
        return $array_result;
    }

    //méthode qui récupère les infos par son id
    public function readById(string $class_name, int $id)
    {
        //on crée la requete
        $q = sprintf('SELECT * FROM %s WHERE id=:id', $this->getTableName());

        //on prépare la requete
        $stmt = $this->pdo->prepare($q);
        //on vérifie que la méthode s'est bien préparée
        if(!$stmt) return null;
        //si OK on execute et on lui donne son paramètre (ici id)
        $stmt->execute(['id' => $id]);
        $row_data = $stmt->fetch();

        return !empty($row_data) ? new $class_name($row_data) : null;
    }
}
