<?php

namespace App\Repository;

use App\Model\User;
use Core\Repository\Repository;
use App\Controller\AuthController;

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
        return $this->readById(User::class, $id);
    }

    public function addTeam(array $data): ?User
    {
        $data_more = [
            'is_admin' => 1,
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
        return $this->readById(User::class, $id);
    }

    //méthode qui récupère l'utilisateur grace à son id
    public function findUserById(int $id): ?User
    {
        return $this->readById(User::class, $id);
    }

    //méthode qui récupère tous les utilisateurs qui ne sont pas admins et qui sont actifs
    public function getAllClientsActif(): array
    {
        //on déclare un tableau vide
        $users = [];
        //on crée la requete sql
        $query = sprintf(
            'SELECT * FROM %s WHERE is_admin = 0 AND is_active = 1',
            $this->getTableName()
        );
        //on peut exécuter directement la requete
        $stmt = $this->pdo->query($query);

        //on vérifie que la requete s'est bien exécutée
        if (!$stmt) return $users;

        //on récupère les résultats
        while ($result = $stmt->fetch()) {
            $users[] = new User($result);
        }
        return $users;
    }

    //méthode qui récupère tous les employés
    public function getAllTeamActif(): array
    {
        //on déclare un tableau vide
        $users = [];
        //on crée la requete sql
        $query = sprintf(
            'SELECT * FROM %s WHERE is_admin=1 AND is_active=1',
            $this->getTableName()
        );
        //on peut exécuter directement la requete
        $stmt = $this->pdo->query($query);

        //on vérifie que la requete s'est bien exécutée
        if (!$stmt) return $users;

        //on récupère les résultats
        while ($result = $stmt->fetch()) {
            $users[] = new User($result);
        }
        return $users;
    }


    //méthode qui désactive un utilisateur
    public function deleteUser(int $id): bool
    {
        //on crée la requete SQL
        $query = sprintf(
            'UPDATE %s SET is_active = 0 WHERE `id` = :id',
            $this->getTableName()
        );

        //on prépare la requete
        $stmt = $this->pdo->prepare($query);

        //on vérifie que la requete est bien préparée
        if (!$stmt) return false;

        //on execute la requete si la requete est passée on retourne true sinon false
        return $stmt->execute(['id' => $id]);
    }


    //TODO:
    //fonction qui récupère toutes les informations de l'utilisateur connecté
    public function getUserActifInfos(): array
    {
        //on déclare un tableau vide
        $user_infos = [];
        //on récupère l'id de l'utilisateur connecté
        $user_id = AuthController::getUserId();

        //on crée la requete sql pour récupérer les informations de l'utilisateur connecté
        $query = sprintf(
            'SELECT `email`, `password`, `lastname`, `firstname`, `address`, `zip_code`, `city`, `country`, `phone` FROM %s WHERE id = :id',
            $this->getTableName()
        );

        //on prépare la requete
        $stmt = $this->pdo->prepare($query);
        //on vérifie que la requete est bien préparée
        if (!$stmt) return false;
        //on execute la requete en bindant le parametre
        $stmt->execute(['id' => $user_id]);

        //on return le tableau
        while ($result = $stmt->fetch()) {
            $user_infos[] = $result;
        }

        return $user_infos;
    }

    //TODO:
    // Méthode qui met à jour la table user dans la base de données
    public function updateUser(User $user): bool
    {
        // Préparer la requête SQL pour mettre à jour l'utilisateur
        $sql = "UPDATE user SET email = :email, lastname = :lastname, firstname = :firstname, address = :address, zip_code = :zip_code, city = :city, phone = :phone WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        if (!$stmt) {
            return false;
        }

        // Exécuter la requête avec les valeurs de l'utilisateur
        return $stmt->execute([
            'email' => $user->email,
            'lastname' => $user->lastname,
            'firstname' => $user->firstname,
            'address' => $user->address,
            'zip_code' => $user->zip_code,
            'city' => $user->city,
            'id' => $user->id,
            'phone' => $user->phone,

        ]);
    }
}
