<?php
namespace App\Model;

use Core\Model\Model;

class Order extends Model
{
    public string $order_number;
    public string $date_order;
    public string $date_delivered;
    public string $status;
    public int $user_id;


    //propriétés d'hydratation
    public User $user;
}