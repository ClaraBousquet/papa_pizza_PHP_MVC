<?php

namespace App\Repository;

use App\Model\User;
use Core\Repository\Repository;

class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'user';
    }

    //méthode qui vérifie si l'utilisateur existe déjà dans la base de données
    public function findUserByEmail(string $email): ?User
    {
        //on crée la requete sql
        $query = sprintf(
            'SELECT * FROM %s WHERE email = :email',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        //on vérifie que la requete est bien préparée
        if (!$stmt) return null;
        //on execute la requete
        $stmt->execute(['email' => $email]);
        //on récupère le résultat
        while ($result = $stmt->fetch()) {
            $user = new User($result);
        }
        return $user ?? null;
    }
    public function addUser(array $data): ?User 
    {
        $data_more = [
            'is_admin' => 0,
            'is_active' => 1,
        ];
        //on fusionne les deux tableaux
        $data = array_merge($data, $data_more);

        //on crée la requete
        $query = sprintf(
            'INSERT INTO %s (`email`, `password`, `lastname`, `firstname`, `phone`, `is_admin`, `is_active`)
            VALUES (:email, :password,:lastname, :firstname, :phone, :is_admin, :is_active)',
            $this->getTableName()
        );

        //on prépare la requete
        $stmt = $this->pdo->prepare($query);
        //ON VÉRIIFIE QUE LA REQUETE EST BIEN PREPAREE
        // Vérification de la préparation de la requête
        if (!$stmt) return null;
            // on execute la requete
        $stmt->execute($data);

        //on récupère l'utilisateur qui vient d'étre ajouté
        $id = $this->pdo->lastInsertId();
        //on récupère l'utilisateur grace a cet id
        return $this->readById(User::class,$id);
        
    }

    //méthode qui récupère l'utilisateur grace à son id
    public function findUserById(int $id): ?User
    {
        return $this->readById(User::class, $id);
    }
}
