<?php

namespace App\Controller;

use Core\View\View;
use App\AppRepoManager;
use Core\Session\Session;
use Core\Controller\Controller;

class UserController extends Controller
{

    //TODO:
    public function account()
    {
        //on vérifie que l'utilisateur est connecté
        if (!AuthController::isAuth()) self::redirect('/');

        $data_view = [
            'users' => AppRepoManager::getRm()->getUserRepository()->getUserActifInfos(),
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view = new View('user/account');

        $view->render($data_view);

        $view = new View('user/account');

        $view->render();
    }

    public function admin()
    {
        $view = new View('user/admin');
        $view->render();
    }

    //fonction qui récupère les données modifiées de "mon compte"
    public function userUpdate()
    {
        // on récupère l'utilisateur
        $user = AppRepoManager::getRm()->getUserRepository()->findUserById(Session::get(Session::USER)->id);

        //on met à jour l'utilisateur avec les nouvelles données
        $user->lastname = $_POST['lastname'] ?? $user->lastname;
        $user->firstname = $_POST['firstname'] ?? $user->firstname;
        $user->email = $_POST['email'] ?? $user->email;
        $user->phone = $_POST['phone'] ?? $user->phone;
        $user->address = $_POST['address'] ?? $user->address;
        $user->zip_code = $_POST['zip_code'] ?? $user->zip_code;
        $user->city = $_POST['city'] ?? $user->city;
        $result = AppRepoManager::getRm()->getUserRepository()->updateUser($user);
        // on met à jour la base de données
        $result = AppRepoManager::getRm()->getUserRepository()->updateUser($user);

        // Si la mise à jour est réussie, on récupère les données mises à jour 

        if ($result) {
            $updatedUser = AppRepoManager::getRm()->getUserRepository()->findUserById($user->id);
            // Transmettre les données mises à jour à la vue 
            $view = new View('user/account');
            $view->render(['user' => $updatedUser]);

        }
    }
}
