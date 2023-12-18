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




    //méthode qui affiche la liste des pizzas personnalisées
    public function pizzaPerso()
    {
        //on s'assure que l'utilisateur est connecté
        if (!AuthController::isAuth()) {
            self::redirect('/connexion');
            return;
        }

        //on récupère l'id de l'utilisateur connecté
        $user_id = Session::get(Session::USER)->id;
        //on appelle la méthode qui affiche la liste des pizzas personnalisées
        $view_data = [
            'pizzas' => AppRepoManager::getRm()->getPizzaRepository()->getPizzasCustom($user_id),
            'AppRepoManager' => AppRepoManager::getRm()
        ];

        $view = new View('home/pizza_perso_list');
        $view->render($view_data);
    }

    //méthode qui reçoit le formulaire d'ajout de pizza
    public function addPizzaPersoForm(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();
        //on crée des variables
        $name = $post_data['name']; //nom de la pizza
        $user_id = $post_data['user_id']; //id de l'utilisateur
        $array_ingredients = $post_data['ingredients']; //tableau des ingredients
        $size_id = $post_data['size_id']; //tableau des tailles
        $form_result = new FormResult();



        if (empty($name) || empty($user_id) || empty($array_ingredients) || empty($size_id)) {
            $form_result->addError(new FormError('Veuillez remplir tous les champs'));
        } elseif (count($array_ingredients) < 1) {
            $form_result->addError(new FormError('Veuillez ajouter au moins un ingredient'));
        } elseif (count($array_ingredients) > 5) {
            $form_result->addError(new FormError('Veuillez ajouter au plus 5 ingredients'));
        } else {

            $data_pizza = [
                'name' => htmlspecialchars(trim($name)),
                'user_id' => intval($user_id),
                'is_active' => 1,
            ];
            $pizza = AppRepoManager::getRm()->getPizzaRepository()->insertPizzaCustom($data_pizza);

            if (!$pizza) {
                $form_result->addError(new FormError('Erreur lors de l\'insertion de la pizza'));
            }

            $pizza_id = $pizza->id;

            foreach ($array_ingredients as $ingredient_id) {
                //on crée un tableau de données
                $data_pizza_ingredient = [
                    'pizza_id' => intval($pizza_id),
                    'ingredient_id' => intval($ingredient_id),
                    'quantity' => 1,
                    'unit_id' => 5
                ];
                //on appelle la méthode qui va insérer les ingrédients de la pizza
                $pizza_ingredient = AppRepoManager::getRm()->getPizzaIngredientRepository()->insertPizzaIngredient($data_pizza_ingredient);
                //on vérifie que l'insertion s'est bien passée
                if (!$pizza_ingredient) {
                    $form_result->addError(new FormError('Erreur lors de l\'insertion des ingrédients de la pizza'));
                }
            }

            if ($size_id == 1) {
                $total_price = 5 + count($array_ingredients) * 0.9;
            } elseif ($size_id == 2) {
                $total_price = 8 + count($array_ingredients) * 1.2;
            } else {
                $total_price = 10 + count($array_ingredients) * 1.5;
            }

            $data_price = [
                'price' => $total_price,
                'pizza_id' => $pizza_id,
                'size_id' => $size_id
            ];

            $price = AppRepoManager::getRm()->getPriceRepository()->insertPrice($data_price);

            if (!$price) {
                $form_result->addError(new FormError('Erreur lors de l\'insertion du prix de la pizza'));
            }
        }
        //si il y a des erreurs
        if ($form_result->hasErrors()) {
            //on stocke les erreurs dans la session
            Session::set(Session::FORM_RESULT, $form_result);
            //on redirige vers la page d'ajout de jouet
            self::redirect('/pizza-personnalisee');
        }
        //sinon on redirige vers la page admin
        Session::remove(Session::FORM_RESULT);
        self::redirect('/user/pizza/perso');
    }

    //méthode qui affiche la vue de création/personnalisation de pizza

    public function createPizza()
    {
        $view = new View('home/pizza_personnalise');
        $view->render();
    }

    //méthode qui reçoit le formulaire d'ajout de pizza
    public function addPizzaForm(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $file_data = $_FILES['image_path'];
        $form_result = new FormResult();
        //on crée des variables
        $name = $post_data['name']; //nom de la pizza
        $user_id = $post_data['user_id']; //id de l'utilisateur
        $array_ingredients = $post_data['ingredients']; //tableau des ingredients
        $array_size = $post_data['size_id']; //tableau des tailles
        $array_price = $post_data['price']; //tableau des prix
        $image_name = $file_data['name']; //nom de l'image
        $tmp_path = $file_data['tmp_name']; //chemin temporaire de l'image
        $public_path = 'public/assets/images/pizza/'; //chemin public de l'image
        $form_result = new FormResult();

        //condition pour restreindre les types de fichiers que l'on souhaite recevoir
        if (
            $file_data['type'] !== 'image/jpeg' &&
            $file_data['type'] !== 'image/png' &&
            $file_data['type'] !== 'image/jpg' &&
            $file_data['type'] !== 'image/webp'
        ) {
            $form_result->addError(new FormError('Le format de l\'image n\'est pas valide'));
        } else if (
            //on vérifie que les autres champs sont remplis
            empty($name) ||
            empty($user_id) ||
            empty($array_ingredients) ||
            empty($array_size) ||
            empty($array_price) ||
            empty($image_name)
        ) {
            $form_result->addError(new FormError('Veuillez remplir tous les champs'));
        } else {

            //on redefinit un nom unique pour l'image
            $filename = uniqid() . '_' . $image_name;
            $slug = explode('.', strtolower(str_replace(' ', '-', $filename)))[0];
            //le chemin de destination
            $imgPathPublic = PATH_ROOT . $public_path . $filename;
            //on reconstruit un tableau de données
            $data_pizza = [
                'name' => htmlspecialchars(trim($name)),
                'image_path' => htmlspecialchars(trim($filename)),
                'user_id' => intval($user_id),
                'is_active' => 1,
            ];

            //on va déplacer le fichier tmp dans son dossier de destination dans une condition
            if (move_uploaded_file($tmp_path, $imgPathPublic)) {
                // appel du repository pour inserer dans la bdd
                $pizza = AppRepoManager::getRm()->getPizzaRepository()->insertPizza($data_pizza);
                //on vérifie que la pizza a bien été insérée
                if (!$pizza) {
                    $form_result->addError(new FormError('Erreur lors de l\'insertion de la pizza'));
                } else {
                    //on récupère l'id de la pizza
                    $pizza_id = $pizza->id;
                    //on va insérer les ingrédients de la pizza
                    foreach ($array_ingredients as $ingredient_id) {
                        //on crée un tableau de données
                        $data_pizza_ingredient = [
                            'pizza_id' => intval($pizza_id),
                            'ingredient_id' => intval($ingredient_id),
                            'quantity' => 1,
                            'unit_id' => 5
                        ];
                        //on appelle la méthode qui va insérer les ingrédients de la pizza
                        $pizza_ingredient = AppRepoManager::getRm()->getPizzaIngredientRepository()->insertPizzaIngredient($data_pizza_ingredient);
                        //on vérifie que l'insertion s'est bien passée
                        if (!$pizza_ingredient) {
                            $form_result->addError(new FormError('Erreur lors de l\'insertion des ingrédients de la pizza'));
                        }
                    }
                    //on va insérer les tailles de la pizza
                    foreach ($array_size as $size_id) {
                        //on crée un tableau de données
                        $data_price = [
                            'pizza_id' => intval($pizza_id),
                            'size_id' => intval($size_id),
                            'price' => floatval($array_price[$size_id - 1])
                        ];
                        //on appelle la méthode qui va insérer les tailles de la pizza
                        $price = AppRepoManager::getRm()->getPriceRepository()->insertPrice($data_price);
                        //on vérifie que l'insertion s'est bien passée
                        if (!$price) {
                            $form_result->addError(new FormError('Erreur lors de l\'insertion des tailles de la pizza'));
                        }
                    }
                }
            } else {
                $form_result->addError(new FormError('Erreur lors de l\'upload de l\'image'));
            }
        }
        //si il y a des erreurs
        if ($form_result->hasErrors()) {
            //on stocke les erreurs dans la session
            Session::set(Session::FORM_RESULT, $form_result);
            //on redirige vers la page d'ajout de jouet
            self::redirect('/admin/pizza/add');
        }
        //sinon on redirige vers la page admin
        Session::remove(Session::FORM_RESULT);
        self::redirect('/admin/pizza/list');
    }
}
