<?php

namespace App\Controller;

use Core\View\View;
use App\AppRepoManager;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use App\Controller\AuthController;
use Laminas\Diactoros\ServerRequest;

class AdminController extends Controller
{
    public function home()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view = new View('admin/home');

        $view->render();
    }

    //liste des clients
    public function listUser()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $data_view = [
            'users' => AppRepoManager::getRm()->getUserRepository()->getAllClientsActif(),
            'form_result' => Session::get(Session::FORM_RESULT)

        ];


        $view = new View('admin/list-user');
        $view->render($data_view);
    }

    public function listTeam()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $data_view = [
            'users' => AppRepoManager::getRm()->getUserRepository()->getAllTeamActif(),
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view = new View('admin/list-team');

        $view->render($data_view);
    }

    public function listPizza()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view = new View('admin/list-pizza');
        $view->render();
    }
    public function listOrder()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view = new View('admin/list-order');
        $view->render();
    }

    //méthode pour désactiver un client
    public function deleteUser(int $id)
    {
        //on vérifie que l'utilisateur est connecté et qu'il est admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $form_result = new FormResult();
        //on appelle la méthode qui désactive un utilisateur
        $deleteUser = AppRepoManager::getRm()->getUserRepository()->deleteUser($id);
        //si la méthode renvoie false on stocke un message d'erreur
        if (!$deleteUser) {
            $form_result->addError(new FormError('Erreur lors de la suppression'));
        }
        //si il y a des erreurs on les enregistre en session
        if ($form_result->hasErrors()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/user/list');
        }
        //si tout est ok  on redirige vers la liste des clients
        self::redirect('/admin/user/list');
    }

    //méthode qui retourne le formulaire d'un membre d'ajout d'un membre de l'équipe
    public function addTeam()
    {
        $view = new View('admin/add-team');

        $view_data = [
            //permet de recupérer les message d'erreurs du formulaire (s'il y en a)
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view->render($view_data);
    }

    //méthode qui reçoit le formualaire
  
}
