<?php

namespace App\Controller;

use Core\View\View;
use App\AppRepoManager;
use Core\Session\Session;
use Core\Controller\Controller;

class PizzaController extends Controller
{



    public function home()
    {
        $view = new View('home/index');
        $view->render();
    }

    //méthode qui récupère la liste des pizzas
    public function getPizzas()
    {
        $view_data = [
            'pizzas' => AppRepoManager::getRm()->getPizzaRepository()->getAllPizzas()
        ];
        $view = new View('home/pizzas');
        $view->render($view_data);
    }

    //méthode qui récupère une pizza par son id
    public function getPizzaById(int $id)
    {
        $view_data = [
            'pizza' => AppRepoManager::getRm()->getPizzaRepository()->getPizzaById($id),
        ];

        $view = new View('home/pizza_detail');
        $view->render($view_data);
    }

    //méthode qui supprime une pizza

}
