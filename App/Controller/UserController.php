<?php

namespace App\Controller;

use Core\View\View;
use App\AppRepoManager;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Laminas\Diactoros\ServerRequest;

class UserController extends Controller
{

    public function account()
    {
        //on vérifie que l'utilisateur est connecté
        if (!AuthController::isAuth()) self::redirect('/');
        $data_view = [
            'users' => AppRepoManager::getRm()->getUserRepository()->findUserById(Session::get(Session::USER)->id)
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

    //méthode qui affiche la vue panier
    public function cart()
    {
        //on s'assure que l'utilisateur est connecté
        if (!AuthController::isAuth()) {
            // Rediriger vers la page de connexion
            self::redirect('/login');
        }

        //on récupère l'id de l'utilisateur connecté
        $user_id = Session::get(Session::USER)->id;
        //on ­récupère la commande de l'utilisateur
        $orderRepository = AppRepoManager::getRm()->getOrderRepository();
        $orderWithRows = $orderRepository->getOrderWithrows($user_id);
        //on donne les données à la vue
        $view_data = [
            'orders' => $orderWithRows,
        ];
        $view = new View('user/cart');
        $view->render($view_data);
    }

  public function addToCart(ServerRequest $request)
{
    // On instancie un nouvel objet FormResult pour gérer les résultats du formulaire
    $form_result = new FormResult();

    // On récupère les données POST de la requête
    $post_data = $request->getParsedBody();

    // On vérifie si les champs nécessaires (user_id, pizza_id, price, quantity) sont remplis
    if (empty($post_data['user_id']) || empty($post_data['pizza_id']) || empty($post_data['price']) || empty($post_data['quantity'])) {
        // on ajoute une erreur au résultat du formulaire si les champs sont vides
        $form_result->addError(new FormError('Veuillez remplir tous les champs'));
    } else {
        // On convertit les valeurs reçues en types appropriés
        $user_id = intval($post_data['user_id']);
        $pizza_id = intval($post_data['pizza_id']);
        $quantity = intval($post_data['quantity']);
        // On calcule le prix total
        $price = floatval($post_data['price'] * $quantity);

        // On génère un numéro de commande unique
        $order_number = uniqid();

        // On définit la date de la commande
        $oder_date = date('Y-m-d');

        // On définit le statut initial de la commande
        $order_status = 'En cours';

        // On prépare les données de la commande pour l'insertion dans la base de données
        $order_data = [
            'user_id' => $user_id,
            'order_number' => $order_number,
            'date_order' => $oder_date,
            'status' => $order_status
        ];

        // On insère la commande dans la base de données et on récupère l'ID de la commande
        $order_id = AppRepoManager::getRm()->getOrderRepository()->insertOrder($order_data);

        // Si l'insertion échoue, on ajoute une erreur au résultat du formulaire
        if (!$order_id) {
            $form_result->addError(new FormError('Une erreur est survenue lors de la création de commande'));
        }

        // On prépare les données pour la ligne de commande
        $order_row_data = [
            'quantity' => $quantity,
            'price' => $price,
            'order_id' => $order_id,
            'pizza_id' => $pizza_id
        ];

        // On insère la ligne de commande dans la base de données
        $order_row_data = AppRepoManager::getRm()->getOrderRowRepository()->insertOrderRow($order_row_data);

        // Si l'insertion échoue, on ajoute une erreur au résultat du formulaire
        if (!$order_row_data) {
            $form_result->addError(new FormError('Une erreur est survenue lors de la création de la commande'));
        }
    }

    // On vérifie si des erreurs ont été enregistrées dans le résultat du formulaire
    if ($form_result->hasErrors()) {
        // Si des erreurs existent, on les stocke dans la session
        Session::set(Session::FORM_RESULT, $form_result);

        // On redirige l'utilisateur vers la page de la pizza concernée
        self::redirect("/pizza/$pizza_id");
    } else {
        // Si aucune erreur n'est présente, on supprime les éventuelles erreurs stockées et on redirige vers le panier de l'utilisateur
        Session::remove(Session::FORM_RESULT);
        self::redirect("/user/cart");
    }
}


