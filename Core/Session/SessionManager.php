<?php 

namespace Core\Session;

abstract class SessionManager 
{
    //creer une méthode qui alimente notre session
    public static function set(string $key,mixed $value): void 
    {
        $_SESSION[$key] = $value;
    }

    //méthode qui permet de récupérer une valeur de la session
    public static function get(string $key): mixed
    {
        if(!isset($_SESSION[$key])) return null;

        return $_SESSION[$key];
    }

    //méthode qui permet de supprimer une valeur de la session
    public static function remove(string $key): void 
    {
        if(!self::get($key)) return;

        unset($_SESSION[$key]);
    }
}