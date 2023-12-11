<?php

namespace App\Controller;

use Core\View\View;
use Core\Controller\Controller;

class UserController extends Controller
{
    public function account(int $id)
    {
        $view = new View('user/account');

        $view->render();
    }

    public function admin()
    {
        $view = new View('user/admin');
        $view->render();
    }
}
