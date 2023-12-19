<?php

namespace App\Repository;

use Core\Repository\Repository;

class OrderRepository extends Repository
{
    public function getTableName(): string
    {
        return 'order';
    }


    //méthode qui insère une nouvelle commande dans la base de données
    public function insertOrder(array $data): int
    {
        //on déclare la requête
        $query = "INSERT INTO `order` (order_number, date_order, status, user_id) VALUES (:order_number, :date_order, :status, :user_id)";
        //on prepare la requête
        $stmt = $this->pdo->prepare($query);
        //on execute la requête
        $stmt->execute($data);
        //on retourne le dernier id inseré
        return $this->pdo->lastInsertId();
    }

    //méthode qui récupère order avec ses lignes associées
    public function getOrderWithrows(int $id)
    {
        //on déclare la requête
        $query = "SELECT * FROM `order` WHERE id = :id";
        //on prepare la requête
        $stmt = $this->pdo->prepare($query);
        //on execute la requête
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
