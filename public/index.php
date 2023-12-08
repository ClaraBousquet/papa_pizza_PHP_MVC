<?php

use App\App;

const DS = DIRECTORY_SEPARATOR;
//PATH_ROOT est le chemin qui me ramène à la racine de mon projet
define('PATH_ROOT', dirname(__DIR__) . DS);


require_once PATH_ROOT . 'vendor' . DS . 'autoload.php';
// on démarre l'application
App::getApp()->start();
