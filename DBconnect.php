<?php

class DBConnect {
    // Paramètres de connexion à la base de données
    private $host = 'localhost';
    private $dbname = 'contacts';
    private $username = 'root';
    private $password = '';
    // Objet PDO qui contiendra la connexion à la base de données
    private $pdo;

    //Construction de la classe qui se lance auto lors de la création d'un objet DBconnect
    //Etablit la connexion à la base de donnée
    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
            // Création de l'objet PDO avec les paramètres de connexion
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
             // Si la connexion échoue, affiche un message d'erreur et arrête le script
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
    //Retourne l'objet PDO pour l'utiliser dans d'autres classes
    public function getPDO() {
        return $this->pdo;
    }
}
?>
