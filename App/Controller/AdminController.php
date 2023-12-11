<?php

namespace App\Controller;

use Core\View\View;
use Core\Controller\Controller;
use App\Controller\AuthController;

class AdminController extends Controller
{
    public function home()
    {
        //on vérifie que l'utilisateur est connecté

        //on vérifie que l'utilisateur est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view = new View('admin/home');

        $view->render();
    }

}
