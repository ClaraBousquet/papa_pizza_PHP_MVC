<?php 

namespace Core\View;

use App\Controller\AuthController;

class View 
{
    //on doit définir le chemin absolu vers le dossier contenant les vues
    //on va utiliser la const de index.php
    public const PATH_VIEW = PATH_ROOT . 'views' . DS;
    //on crée une seconde constante pour le chemin vers le dossier contenant les templates
    public const PATH_PARTIALS = self::PATH_VIEW . '_templates' . DS;
    //on déclare une propriete titre par defaut
    public string $title = 'Titre par défaut';

    // on déclare le constructeur
    public function __construct(private string $name, private bool $is_complete = true)
    {}

    //méthode pour récupérer le chemin de la vue
    private function getRequirePath():string
    {
        //explode() permet de découper une chaine de caractère en tableau
        $arr_name = explode('/' , $this->name);
        //on récupère le premier élément du tableau
        $category = $arr_name[0];
        //on récupère le second élément du tableau
        $name = $arr_name[1];
        //si on crée un template on ajoutera un _ devant le nom du fichier
        $name_prefix = $this->is_complete ? '' : '_';

        return self::PATH_VIEW . $category . DS . $name_prefix . $name . '.html.php';
    }

    //on crée la méthode de rendu
    public function render(?array $view_data = [])
    {
        //on récupère les données de l'utilisateur
        $auth = AuthController::class;

        if(!empty($view_data)) {
            //on extrait les données du tableau
            extract($view_data);
        }
        //Mise en cache du contenu de la vue
        ob_start();

        //on import le template header si la vue est complète
        if($this->is_complete) {
            require_once self::PATH_PARTIALS . '_header.html.php';
        }

        require_once $this->getRequirePath();

        //on import le template footer si la vue est complète
        if($this->is_complete) {
            require_once self::PATH_PARTIALS . '_footer.html.php';
        }

        //libération du cache
        ob_end_flush();
    }
}