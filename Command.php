<?php

require_once 'ContactManager.php';

class Command
{
    private $contactManager;

    public function __construct($contactManager)
    {
        $this->contactManager = $contactManager;
    }
    public function list()
    {
        $contacts = $this->contactManager->findAll();

        if (count($contacts) === 0) {
            echo "Aucun contact trouvé.\n";
        } else {
            echo "Liste des contacts :\n";
            foreach ($contacts as $contact) {
                echo $contact . "\n";
            }

        }
    }

    public function detail($id)
    {

        if (!is_numeric($id)) {
            echo "Erreur : l'ID doit être un nombre.\n";
            return;
        }
        $contact = $this->contactManager->findById($id);

        if ($contact === null) {
            echo "Aucun contact trouvé avec l'ID $id.\n";
        } else {
            echo "Détail du contact :\n";
            echo $contact->toString() . "\n";
        }
    }
    public function create($name, $email, $phone_number)
    {
        //Vérifier que tous les paramètres sont fournis
        if (empty($name) || empty($email) || empty($phone_number)) {
            echo "Erreur : tous les paramètres sont requis.\n";
            return;
        }
        $sucess = $this->contactManager->insert($name, $email, $phone_number);

        if ($sucess) {
            echo "Contact créé avec succès !\n";
        } else {
            echo "Erreur lors de la création du contact.\n";
        }
    }
    public function delete($id)
    {
        //Vérifier que l'ID est un nombre
        if (!is_numeric($id)) {
            echo "Erreur : l'ID doit être un nombre.\n";
            return;
        }
        //Vérifier que le contact existe 
        $contact = $this->contactManager->findById($id);
        if ($contact === null) {
            echo "Aucun contact trouvé avec l'ID $id.\n";
            return;
        }

        //Supprimer le contact
        $success = $this->contactManager->delete($id);

        if ($success) {
            echo "Contact supprimé avec succès !\n";
        } else {
            echo "Erreur lors de la suppression du contact.\n";
        }
    }

    public function modify($id, $name, $email, $phone_number)
    {
        //Vérifier que l'id est un nombre
        if (!is_numeric($id)) {
            echo "Erreur : l'ID doit être un nombre.\n";
            return;
        }

        //Vérifier que tous les paramètres sont fournis
        if (empty($name) || empty($email) || empty($phone_number)) {
            echo "Erreur  : tous les paramètres sont requis.\n";
            return;
        }
        //Vérifier que le contact existe
        $contact = $this->contactManager->findById($id);
        if ($contact === null) {
            echo "Aucun contact trouvé avec l'ID $id.\n";
            return;
        }

        //Modifier le contact
        $success = $this->contactManager->update($id, $name, $email, $phone_number);

        if ($success) {
            echo "Contact modifié avec succès !\n";
        } else {
            echo "Erreur lors de la modification du contact.\n";
        }
    }
    public function help()
    {
        echo "\n=== Commandes disponibles ===\n";
        echo " list                                             - Affiche tous les contacts\n";
        echo "detail <id>                                       - Affiche les détails d'un contact\n";
        echo "create \"<nom>\" \"<email>\" \"<téléphone>\"      - Crée un nouveau contact\n";
        echo "delete <id>                                       - Supprime un contact\n";
        echo "modify <id> \"<nom>\" \"<email>\" \"<téléphone>\" - Modifie un contact\n";
        echo "help                                              - Affiche cette aide\n";
    }
}



