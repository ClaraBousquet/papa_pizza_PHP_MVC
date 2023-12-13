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
            'SELECT p.`id`, p.`name`, p.`image_path`
            FROM `%1$s` AS p
            INNER JOIN %2$s AS u ON p.`user_id` = u.`id`
            WHERE p.`is_active` = 1
            AND u.`is_admin` =1',
            $this->getTableName(),
            AppRepoManager::getRm()->getUserRepository()->getTableName()
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
    //totues les pizzas a vec infos
    public function getAllPizzasWithInfo(): array
    {

        //on déclare un tableau vide
        $array_result = [];

        //on délcare la requete SQL
        $query = sprintf(
            'SELECT p.`id`, p.`name`, p.`image_path`
            FROM `%1$s` AS p
            INNER JOIN %2$s AS u ON p.`user_id` = u.`id`
            WHERE p.`is_active` = 1
            AND u.`is_admin` =1',
            $this->getTableName(),
            AppRepoManager::getRm()->getUserRepository()->getTableName()
        );

        //on peut directement executer la requete avec la methode query()
        $stmt = $this->pdo->query($query);
        //on vérifie si la requete s'est bien exécutée
        if (!$stmt) return $array_result;

        //On récupère les données de la table dans une boucle
        while ($row_data = $stmt->fetch()) {
            $pizza = new Pizza($row_data);
            //on hydrate les ingrédients de la pizza
            $pizza->ingredients = AppRepoManager::getRm()->getPizzaIngredientRepository()->getIngredientsByPizzaId($pizza->id);
            $pizza->prices = AppRepoManager::getRm()->getPriceRepository()->getPriceByPizzaId($pizza->id);

            $array_result[] = $pizza;
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
        if (!$result) return null;

        //si jai un resultat un retourne une instance de pizza
        $pizza = new Pizza($result);

        //on va hydrater la pizza avec les ingredients de la pizza
        $pizza->ingredients = AppRepoManager::getRM()->getPizzaIngredientRepository()->getIngredientsByPizzaId($pizza->id);
        //on hydrate les prix de la pizza
        $pizza->prices = AppRepoManager::getRM()->getPriceRepository()->getPriceByPizzaId($pizza->id);

        return $pizza;
    }

    //méthode qui permet de créer une pizza
    public function insertPizza(array $data): ?Pizza
    {
        //on crée la requete
        $query = sprintf(
            'INSERT INTO %s (`name`, `image_path`, `is_active`, `user_id`)
            VALUES(:name, :image_path, :is_active, :user_id)',
            $this->getTableName()
        );
        //on prepare la requete
        $stmt = $this->pdo->prepare($query);

        //on vérifie que la requete est bien préparée
        if(!$stmt) return null;

        //on execute la requete en bindant les parametres
        $stmt->execute($data);

        //on récupère l'id de la pizza fraichement crée
        $pizza_id = $this->pdo->lastInsertId();//return le dernier id qui vient detre inséré

        //on retourne la pizza
        return $this->getPizzaById($pizza_id);
    }

    //méthode qui supprime une pizza
    // public function deletePizza(int $pizza_id): bool
    // {
    //     //on crée la requete SQL
    //     $query = sprintf(
    //         'UPDATE %s SET is_active = 0 WHERE `id` = :id',
    //         $this->getTableName()
    //     );

    //     //on prépare la requete
    //     $stmt = $this->pdo->prepare($query);

    //     //on vérifie que la requete est bien préparée
    //     if (!$stmt) return false;

    //     //on execute la requete si la requete est passée on retourne true sinon false
    //     return $stmt->execute(['id' => $pizza_id]);
    // }
}
