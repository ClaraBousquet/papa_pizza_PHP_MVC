<?php
namespace App\Model;

use Core\Model\Model;

class User extends Model
{
    public string $email;
    public string $password;
    public string $lastname;
    public string $firstname;
    public string $address;
    public string $zip_code;
    public string $city;
    public string $country;
    public string $phone;
    public bool $is_admin;
    public bool $is_active;
}