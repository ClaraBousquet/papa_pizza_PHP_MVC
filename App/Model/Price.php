<?php
namespace App\Model;

use Core\Model\Model;

class Price extends Model{
    public float $price;
    public int $size_id;
    public int $pizza_id;

    public Size $size;
    public Pizza $pizza;
}