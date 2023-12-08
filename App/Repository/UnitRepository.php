<?php

namespace App\Repository;

use Core\Repository\Repository;

class UnitRepository extends Repository
{
    public function getTableName(): string
    {
        return 'unit';
    }
}