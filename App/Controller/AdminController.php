<?php

namespace App\Controller;

use Core\View\View;
use App\Model\Pizza;
use App\AppRepoManager;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use App\Controller\AuthController;
use Laminas\Diactoros\ServerRequest;

class AdminController extends Controller
{
    public function getTableName(): string
    {
        return 'pizza';
    }
    public function home()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view = new View('admin/home');

        $view->render();
    }

    //liste des clients
    public function listUser()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $data_view = [
            'users' => AppRepoManager::getRm()->getUserRepository()->getAllClientsActif(),
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view = new View('admin/list-user');

        $view->render($data_view);
    }

    //liste des membres de l'équipe
    public function listTeam()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $data_view = [
            'users' => AppRepoManager::getRm()->getUserRepository()->getAllTeamActif(),
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view = new View('admin/list-team');

        $view->render($data_view);
    }

    //liste des pizzas
    public function listPizza()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view_data = [
            'pizzas' => AppRepoManager::getRm()->getPizzaRepository()->getAllPizzasWithInfo(),
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view = new View('admin/list-pizza');

        $view->render($view_data);
    }

    //liste des commandes
    public function listOrder()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view = new View('admin/list-order');

        $view->render();
    }

    //on désactive un utilisateur
    public function deleteUser(int $id)
    {
        //on vérifie que l'utilisateur est connecté et qu'il est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $form_result = new FormResult();
        //on appelle la méthode qui désactive un utilisateur
        $deleteUser = AppRepoManager::getRm()->getUserRepository()->deleteUser($id);
        //si la méthode renvoie false on stock un message d'erreur
        if (!$deleteUser) {
            $form_result->addError(new FormError('Une erreur est survenue lors de la suppression de l\'utilisateur'));
        }
        // s'il y a des erreur on les enregistre en session
        if ($form_result->hasErrors()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/user/list');
        }
        //si tout est OK on redirige vers la liste des utilisateurs
        //on supprime la session form_result
        Session::remove(Session::FORM_RESULT);
        self::redirect('/admin/user/list');
    }



    //méthode qui retourne le formulaire d'ajout d'un membre d'équipe
    public function addTeam()
    {
        //on vérifie que l'utilisateur est connecté et qu'il est un admin
        if (!AuthController::isAuth() || !AuthController::isAdmin()) self::redirect('/');

        $view = new View('admin/add-team');

        $view_data = [
            //permet de recupérer les message d'erreurs du formulaire (s'il y en a)
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view->render($view_data);
    }

    //méthode qui retourne le formulaire d'ajout de pizza
    public function addPizza()
    {

        $view_data = [
            //permet de recupérer les message d'erreurs du formulaire (s'il y en a)
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view = new View('admin/add-pizza');

        $view->render($view_data);
    }

    //méthode qui supprime une pizza

    public function deletePizza(int $id)
    {
        // Vérification des droits d'administrateur
        if (!AuthController::isAuth() || !AuthController::isAdmin()) {
            self::redirect('/');
        }
        $form_result = new FormResult();
        // Appel à la méthode de suppression dans le repository
        $deletePizza = AppRepoManager::getRm()->getPizzaRepository()->deletePizza($id);
        if (!$deletePizza) {
            $form_result->addError(new FormError('Une erreur est survenue lors de la suppression de la pizza'));
        }
        if ($form_result->hasErrors()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/pizza/list');
        }
        // Redirection après la suppression réussie
        Session::remove(Session::FORM_RESULT);
        self::redirect('/admin/pizza/list');
    }

    //méthode qui permet de mofifier une pizza
    public function editPizza(int $id)
    {
        $pizza = AppRepoManager::getRm()->getPizzaRepository()->getPizzaById($id);
        if (!$pizza) {
            self::redirect('/admin/pizza/list');
        }
        $view = new View('admin/edit-pizza');
        $view->render(['pizza' => $pizza]);
    }



    //TODO:fonction qui affiche les pizzas déjà crée

public function pizzaPerso()
{
    $view = new View('home/pizza_perso_list');
    $view->render();
}

    //méthode qui reçoit le formulaire d'ajout de pizza
    public function addPizzaPersoForm(ServerRequest $request)
    {
        //je définis les variables de size_id, name et ingredients
        $size_id = $_POST['size_id'] ?? null;
        $name = $_POST['name'] ?? null;
        $ingredients = $_POST['ingredients'] ?? null;
        $totalPrice = 0;
        $price = 0;
        $ingredient = 0;
        // Définir les prix de base en fonction de la taille
        if ($size_id == 1) {
            $price = 10;
            $ingredientPrice = 1;
        } elseif ($size_id == 2) {
            $price = 11;
        } elseif ($size_id == 3) {
            $price = 12;
        }

        //($price + longueur du tableau ingrédient)*prix de l'ingrédient
        // Calcul du prix total
        $totalPrice = ($price + count($ingredients)) * $ingredientPrice;
        echo "Prix de la pizza  : " . $totalPrice . "€";
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        //on instancie une nouvelle pizza
        $pizza = new Pizza();

        //on instancie une nouvelle vue
        $view = new View('admin/add-pizza');
        $view->render();
    }


    //méthode qui affiche la vue de création/personnalisation de pizza

    public function createPizza()
    {
        $view = new View('home/pizza_personnalise');
        $view->render();
    }





}







  






    





    //TODO: méthode qui supprime une pizza
