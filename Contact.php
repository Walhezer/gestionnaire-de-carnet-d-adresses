<?php
//classe qui représente un contact avec ses infos 
class Contact
{
    private $id;
    private $name;
    private $email;
    private $phone_number;
    // méthode lors de la création du contact
    public function __construct($id = null, $name = null, $email = null, $phone_number = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    // Getter pour l'ID
    public function getId()
    {
        return $this->id;
    }

    // Getter pour le nom
    public function getName()
    {
        return $this->name;
    }

    // Setter pour le nom
    public function setName($name)
    {
        $this->name = $name;
    }

    // Getter pour l'email
    public function getEmail()
    {
        return $this->email;
    }

    // Setter pour l'email
    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Getter pour le téléphone
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    // Setter pour le téléphone
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    // Méthode toString pour afficher le contact
    public function __toString()
    {
        return "ID: {$this->id}, Nom: {$this->name}, Email: {$this->email}, Téléphone: {$this->phone_number}";
    }
}
?>