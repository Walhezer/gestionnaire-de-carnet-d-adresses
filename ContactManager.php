<?php

require_once 'Contact.php';
//Classe qui permet de gerer un contact (recuperer les contacts, chercher, creer, modifier,supprimer)
class ContactManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(){
         // Requête SQL pour récupérer tous les contacts
        $sql = "SELECT * FROM contact";
        $stmt = $this->pdo->prepare($sql); // $stmt contient maintenant la requête préparée
        $stmt->execute(); // Exécute la requête
       
        // Récupère tous les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); 

         // Créer un tableau pour stocker les objets Contact
        $contacts = [];

        // Transformer chaque ligne en objet Contact
        foreach ($results as $row) {
            $contact = new Contact(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone_number']
            );
            // Ajouter l'objet Contact au tableau
            $contacts[] = $contact;

        }
        // Retourner le tableau d'objets Contact
        return $contacts;
    }
    public function findById($id) {
        $sql = "SELECT * FROM contact WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }
        $contact = new Contact(
            $row['id'],
            $row['name'],
            $row['email'],
            $row['phone_number']    
        );

        return $contact;
    }
    public function insert($name, $email, $phone_number) {
        $sql = "INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);

        return $stmt->execute();

    }
    public function delete($id) {
    $sql = "DELETE FROM contact WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    return $stmt->execute();
    }
    
    public function update($id, $name, $email, $phone_number) {
        $sql = "UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);

        return $stmt->execute();
    }

}

?>