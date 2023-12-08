<?php

namespace App\Repository;

use Core\Repository\Repository;

class OrderRepository extends Repository
{
    public function getTableName(): string
    {
        return 'order';
    }
}