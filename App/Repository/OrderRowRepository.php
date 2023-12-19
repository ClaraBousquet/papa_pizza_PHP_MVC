<?php

namespace App\Repository;

use Core\Repository\Repository;

class OrderRowRepository extends Repository
{
    public function getTableName(): string
    {
        return 'order_row';
    }

    public function insertOrderRow(array $data) : bool
    {
        //on declare la requête
        $query = "INSERT INTO order_row (order_id, pizza_id, quantity, price) VALUES (:order_id, :pizza_id, :quantity, :price)";
        //on prepare la requête
        $stmt = $this->pdo->prepare($query);
        //on execute la requête
       return $stmt->execute($data);
      
    
    }
}
