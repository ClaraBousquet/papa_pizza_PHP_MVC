<?php 

namespace Core\Repository;

trait RepositoryManagerTrait 
{
    /**
     * un trait permet de gérer une portion de code directement dans une ou plusieurs classes
     * sans notion de hierarchie
     * le terme self dans un trait fait référence à la classe qui utilise le trait
     * Ici on a un design pattern singleton
     */
    private static ?self $rm_instance = null;

    public static function getRm(): self
    {
        if (is_null(self::$rm_instance)) {
            self::$rm_instance = new self();
        }
        return self::$rm_instance;
    }

    protected function __construct(){}
    private function __clone(){}
}