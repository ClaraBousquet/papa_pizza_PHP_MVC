<?php

namespace App\Controller;

use App\AppRepoManager;
use App\Model\User;
use Core\View\View;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Laminas\Diactoros\ServerRequest;

class AuthController extends Controller
{
    //méthode qui vérifie que l'email est valide
    public function validEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //méthode qui vérifie que le mot de passe est valide
    //(au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre)
    public function validPassword(string $password): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/', $password);
    }

    //méthode qui vérifie si l'utilisateur existe déjà dans la base de données
    public function userExist(string $email): bool
    {
        $user = AppRepoManager::getRm()->getUserRepository(User::class)->findUserByEmail($email);
        return !is_null($user);
    }

    //méhode quiformate les inputs du formulaire de connexion
    public function validInputs(string $value)
    {
        //on met toute la string en minuscule
        //$value = strtolower($value);
        //on supprime tous les espaces en début et en fin de string
        $value = trim($value);
        //on supprime les balises HTML
        $value = strip_tags($value);
        //on supprime les antislashs
        $value = stripslashes($value);
        //on supprime les caractères speciaux
        $value = htmlspecialchars($value);

        return $value;
    }


    //méthode qui renvoi sur la vue du formulaire de connexion
    public function loginForm()
    {
        $view = new View('auth/login');

        $view_data = [
            //permet de recupérer les message d'erreurs du formulaire (s'il y en a)
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view->render($view_data);
    }
    //méthode qui receptionne les données du formulaire de connexion
    public function login(ServerRequest $request)
    {
        //on récupère les données du formulaire sous forme de tableau associatif
        $post_data = $request->getParsedBody();
        //on instancie notre class FormResult (elle s'occupe de stocker les messages d'erreur dans la session)
        $form_result = new FormResult();
        //on instancie un User
        $user = new User();

        //on vérifie que les champs soient remplis
        if (empty($post_data['email']) || empty($post_data['password'])) {
            $form_result->addError(new FormError('Veuillez renseigner tous les champs'));
        } else {
            $email = strtolower($this->validInputs($post_data['email']));
            //on va vérifier que l'email existe en bdd
            $user = AppRepoManager::getRm()->getUserRepository()->findUserByEmail($email);

            //si on a un retour négatif
            if (is_null($user)) {
                $form_result->addError(new FormError('Email et/ou mot de passe incorrect'));
            } else {
                //si on a un retour positif on vérifie le mot de passe
                if (!password_verify($this->validInputs($post_data['password']), $user->password)) {
                    $form_result->addError(new FormError('Email et/ou mot de passe incorrect'));
                }
            }
        }
        //si on a des erreurson les stock en session et on renvoie vers la page de connexion
        if ($form_result->hasErrors()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/connexion');
        }

        //si tout est OK on stock l'utilisateur en session et on le redirige vers la page d'accueil
        $user->password = '';
        Session::set(Session::USER, $user);
        self::redirect('/');
    }

    public function registerForm()
    {
        $view = new View('auth/register');

        $view_data = [
            //permet de recupérer les message d'erreurs du formulaire (s'il y en a)
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view->render($view_data);
    }

    //méthode qui réceptionne les données du formulaire d'inscription

    public function register(ServerRequest $request)
    {
        $data_form = $request->getParsedBody();
        $form_result = new FormResult();
        $user = new User();

        //on verfie que les champs soient remplis
        if (
            empty($data_form['email']) ||
            empty($data_form['password']) ||
            empty($data_form['password_confirm']) ||
            empty($data_form['lastname']) ||
            empty($data_form['firstname']) ||
            empty($data_form['phone'])
        ) {
            $form_result->addError(new FormError('Veuillez renseigner tous les champs'));
            //on vérifie que les mots de passe soient identiques
        } else if ($data_form['password'] !== $data_form['password_confirm']) {
            $form_result->addError(new FormError('Les mots de passe ne sont pas identiques'));
            //on vérifi que l'email est valide
        } else if (!$this->validEmail($data_form['email'])) {
            $form_result->addError(new FormError('Veuillez renseigner une adresse email valide'));
            //on vérifie que le mot de passe est valide
        } else if (!$this->validPassword($data_form['password'])) {
            $form_result->addError(new FormError('le mot de passe doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule et 1 chiffre'));
            //on vérifie que l'email n'est pas déjà utilisé
        } else if ($this->userExist($data_form['email'])) {
            $form_result->addError(new FormError('Cet email est déjà utilisé'));
        } else {
            //on peut enregistrer l'utilisateur
            $data_user = [
                'email' => $this->validInputs($data_form['email']),
                'password' => password_hash($this->validInputs($data_form['password']), PASSWORD_BCRYPT),
                'lastname' => $this->validInputs($data_form['lastname']),
                'firstname' => $this->validInputs($data_form['firstname']),
                'phone' => $this->validInputs($data_form['phone'])
            ];
            $user = AppRepoManager::getRM()->getUserRepository()->addUser($data_user);
        }

        //sil y a des erreurs on les stocke en session
        //et on redirection vers la page d'inscription
        if ($form_result->hasErrors()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/inscription');
        }

        //si tout est OK on stock l'utilisateur en session et on le redirige vers la page d'accueil
        //on oublie pas de supprimer le mot de passe
        $user->password = '';
        Session::set(Session::USER, $user);
        //on redirige sur la page d'accueil
        self::redirect('/');
    }

    //méthode qui permet de vérifier si un utilisateur est connecté
    public static function isAuth(): bool
    {
        return !is_null(Session::get(Session::USER));
    }

    //méthode qui vérifie si l'utilisateur est un admin
    public static function isAdmin(int $id): bool
    {
        $user = AppRepoManager::getRm()->getUserRepository(User::class)->findUserById($id);
        return $user->is_admin;
    }
}
