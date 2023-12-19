<?php

namespace App;

use MiladRahimi\PhpRouter\Router;
use App\Controller\AuthController;
use App\Controller\UserController;
use App\Controller\AdminController;
use App\Controller\PizzaController;
use Core\Database\DatabaseConfigInterface;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Exceptions\InvalidCallableException;

class App implements DatabaseConfigInterface
{
    //on déclare des constantes pour la connexion à la base de données
    private const DB_HOST = 'database';
    private const DB_NAME = 'papaizza';
    private const DB_USER = 'admin';
    private const DB_PASS = 'admin';

    //on déclare une propriété privée qui va contenir une intance de app
    //Design pattern Singleton
    private static ?self $instance = null;

    //méthode public appelé au démarrage de l'application dans index.php
    public static function getApp(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //On va configurer notre router
    private Router $router;

    public function getRouter(): Router
    {
        return $this->router;
    }

    private function __construct()
    {
        $this->router = Router::create();
    }

    //on aura 3 méthodes à définir pour le router
    //1: méthode start() qui va démarrer le router dans l'application
    public function start(): void
    {
        //on ouvre l'accès à la session
        session_start();
        //on enregistre les routes
        $this->registerRoutes();
        //on démarre le router
        $this->startRouter();
    }

    //2: méthode qui enregistre les routes
    private function registerRoutes()
    {
        //exemple de routes avec un controller
        // $this->router->get('/', [ToyController::class, 'index']);
        $this->router->get('/', [PizzaController::class, 'home']);
        $this->router->get('/pizzas', [PizzaController::class, 'getPizzas']);
        $this->router->get('/pizza/{id}', [PizzaController::class, 'getPizzaById']);
        //route pour le formulaire de login
        $this->router->get('/connexion', [AuthController::class, 'loginForm']);
        $this->router->post('/login', [AuthController::class, 'login']);
        //route pour le traitement du formulaire d'inscription
        $this->router->get('/inscription', [AuthController::class, 'registerForm']);
        //route qui receptionne les données du formulaire d'inscription
        $this->router->post('/register', [AuthController::class, 'register']);
        //route pour se deconnecter
        $this->router->get('/logout', [AuthController::class, 'logout']);
        //route pour accéder au compte de l'utilisateur
        $this->router->get('/account/{id}', [UserController::class, 'account']);

        /* PARTIE BACK OFFICE */
        //route pour afficher l'interface administrateur
        $this->router->get('/admin/home', [AdminController::class, 'home']);
        $this->router->get('/admin/user/list', [AdminController::class, 'listUser']);
        $this->router->get('/admin/team/list', [AdminController::class, 'listTeam']);
        $this->router->get('/admin/pizza/list', [AdminController::class, 'listPizza']);
        $this->router->get('/admin/order/list', [AdminController::class, 'listOrder']);

        //route pour "supprimer" un utilisateur
        $this->router->get('/admin/user/delete/{id}', [AdminController::class, 'deleteUser']);
        //route pour supprimer une pizza
        $this->router->get('/admin/pizza/delete/{id}', [AdminController::class, 'deletePizza']);
        //route pour ajouter un membre de l'&quipe
        $this->router->get('/admin/team/add', [AdminController::class, 'addTeam']);
        //route qui recevra les formulaires d'ajout d'un membre de l'équipe
        $this->router->post('/register-team', [AuthController::class, 'registerTeam']);

        //route pour ajouter une pizza
        $this->router->get('/admin/pizza/add', [AdminController::class, 'addPizza']);
        //route pour ajouter une pizza personnalisée
        $this->router->get('/pizza-personnalisee', [AdminController::class, 'createPizza']);
        //route qui réceptionne les données du formualire d'ajout d'une pizza personnalisée
        $this->router->post('/add-pizza-perso-form', [AdminController::class, 'addPizzaPersoForm']);
        //route pour afficher ses pizzas crées
        $this->router->get('/user/pizza/perso', [AdminController::class, 'pizzaPerso']);
        //route qui réceptionne les données du formulaire d'ajout d'une nouvelle pizza
        $this->router->post('/add-pizza-form', [AdminController::class, 'addPizzaForm']);
        //route pour interface "mon compte"
        $this->router->get('/user/account', [AdminController::class, 'account']);
        //route qui récupère les données modifiées de l'interface mon compte
        $this->router->post('/user/update', [UserController::class, 'userUpdate']);
        //route pour interface panier
        $this->router->get('/user/cart', [UserController::class, 'cart']);
        //route qui récupère formulaire bouton ajouté au panier
        $this->router->post('/add-to-cart', [UserController::class, 'addToCart']);

    }

    //3: méthode qui va démarrer le router
    private function startRouter()
    {
        try {
            $this->router->dispatch();
        } catch (RouteNotFoundException $e) {
            //TODO : gérer la vue 404
            var_dump('Erreur 404: ' . $e);
        } catch (InvalidCallableException $e) {
            //TODO : gérer la vue 500
            var_dump('Erreur 500: ' . $e);
        }
    }

    //on déclare nos méthodes imposé par l'interface DatabaseConfigInterface
    public function getHost(): string
    {
        return self::DB_HOST;
    }

    public function getName(): string
    {
        return self::DB_NAME;
    }

    public function getUser(): string
    {
        return self::DB_USER;
    }

    public function getPass(): string
    {
        return self::DB_PASS;
    }
}
