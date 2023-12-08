<?php

namespace App\Repository;

use Core\Repository\Repository;

class OrderRowRepository extends Repository
{
    public function getTableName(): string
    {
        return 'order_row';
    }
}