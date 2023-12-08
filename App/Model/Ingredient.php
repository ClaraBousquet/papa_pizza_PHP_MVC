<?php
namespace App\Model;

use Core\Model\Model;

class Ingredient extends Model
{
    public string $label;
    public string $category;
    public bool $is_allergic;
    public bool $is_active;
}