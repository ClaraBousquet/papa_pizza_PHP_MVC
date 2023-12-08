<?php 

namespace Core\Form;

class FormResult 
{
    //gestion des messages de réussite
    private string $success_message;

    public function getSuccessMessage(): string
    {
        return $this->success_message;
    }

    //gestion des messages d'erreurs
    private array $form_errors = [];

    public function getErrors(): array
    {
        return $this->form_errors;
    }

    //méthode qui vérifie si on a des erreurs
    public function hasErrors(): bool
    {
        return !empty($this->form_errors);
    }

    //méthode qui permet d'ajouter un message d'erreur
    public function addError(FormError $error)
    {
        $this->form_errors[] = $error;
    }
}