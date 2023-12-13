<?php

namespace App\Repository;

use App\Model\Size;
use App\Model\Price;
use App\AppRepoManager;
use Core\Repository\Repository;

class PriceRepository extends Repository
{
    public function getTableName(): string
    {
        return 'price';
    }

    //méthode qui récupère les prixs d'une pizza
    public function getPriceByPizzaId(int $pizza_id)
    {

        //on déclare un tableau vide
        $array_result = [];

        //on crée la requete sql
        $query = sprintf(
            'SELECT pr.*, s.label 
            FROM  %1$s AS pr 
            INNER JOIN %2$s AS s ON pr.size_id = s.id 
            WHERE pr.pizza_id =:id',
            $this->getTableName(),
            AppRepoManager::getRM()->getSizeRepository()->getTableName()
        );
        //on prépare la requete
        $stmt = $this->pdo->prepare($query);

        //on vérifie si la requete s'est bien préparee
        if (!$stmt) return $array_result;

        //on execute la requete en bindant le parametre
        $stmt->execute(['id' => $pizza_id]);

        //on recupere les resultats (assez fréquent, à connaitre)
        while ($row_data = $stmt->fetch()) {
            $price = new Price($row_data);

            //on doit reconstruire un tableau pour crer une instance de size
            $size_data = [
                'id' => $row_data['size_id'],
                'label' => $row_data['label']
            ];
            $size = new Size($size_data);
            //on hydrate price avec size
            $price->size = $size;
            $array_result[] = $price;
        }
        //on retourne le tableau
        return $array_result;
    }

    //méthode pour créer un prix
    public function insertPrice(array $data): bool
    {
        //on crée la requete
        $query = sprintf(
            'INSERT INTO %s (`price`, `size_id`, `pizza_id`)
        VALUES (:price, :size_id, :pizza_id)',
            $this->getTableName()
        );
        //on prepare la requete
        $stmt = $this->pdo->prepare($query);
        //on vérifie que la requete est bien préparée
        if (!$stmt) return false;

        //on exécute la requete en bindant les parametres
        $stmt->execute($data);

        //on vérifie que au moins une ligne a été enregistrée
        return $stmt->rowCount() > 0;
    }
}
