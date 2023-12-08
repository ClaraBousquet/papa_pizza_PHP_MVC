<?php

namespace App\Repository;

use App\AppRepoManager;
use App\Model\Pizza;
use Core\Repository\Repository;

class PizzaRepository extends Repository
{
    public function getTableName(): string
    {
        return 'pizza';
    }

    //on crée une méthode qui récupère toutes les pizzas
    public function getAllPizzas(): array
    {

        //on déclare un tableau vide
        $array_result = [];

        //on délcare la requete SQL
        $query = sprintf(
            'SELECT `id`, `name`, `image_path`
            FROM `%s` 
            WHERE `user_id`=1 
            AND `is_active`=1',
            $this->getTableName()
        );

        //on peut directement executer la requete avec la methode query()
        $stmt = $this->pdo->query($query);
        //on vérifie si la requete s'est bien exécutée
        if (!$stmt) return $array_result;

        //On récupère les données de la table dans une boucle
        while ($row_data = $stmt->fetch()) {
            $array_result[] = new Pizza($row_data);
        }


        return $array_result;
    }

    //on crée une pizza qui va recuperer une pizza par son id
    public function getPizzaById(int $pizza_id): ?Pizza
    {
        //je crée ma requete
        $query = sprintf(
            'SELECT * FROM %s WHERE id=:id',
            $this->getTableName()
        );

        //on prépare la requete
        $stmt = $this->pdo->prepare($query);

        //on vérifie si la requete s'est bie,n prépareée
        if (!$stmt) return null;

        //on execute la requete en bindant les parametres
        $stmt->execute(['id' => $pizza_id]);

        //on récupère le resultat
        $result = $stmt->fetch();
//si je nai pas de resultat on retourne null
        if(!$result) return null;

        //si jai un resultat un retourne une instance de pizza
        $pizza = new Pizza($result);

        //on va hydrater la pizza avec les ingredients de la pizza
        $pizza->ingredients = AppRepoManager::getRM()->getPizzaIngredientRepository()->getIngredientsByPizzaId($pizza->id);
        //on hydrate les prix de la pizza
        $pizza->prices = AppRepoManager::getRM()->getPriceRepository()->getPriceByPizzaId($pizza->id);

    return $pizza;

    }
}
