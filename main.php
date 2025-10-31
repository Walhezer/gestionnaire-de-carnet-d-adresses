<?php
// Charge les classes dont on a besoin pour faire fonctionner l'application
require_once 'DBConnect.php';
require_once 'ContactManager.php';
require_once 'Command.php';

// Créer un objet DBConnect qui établit automatiquement la connexion MySQL
$dbConnect = new DBConnect();
// Récupère l'objet PDO depuis DBConnect
$pdo = $dbConnect->getPDO();

// Créer une instance de ContactManager
$contactManager = new ContactManager($pdo);
//Créer une instance de Command en lui passant le ContactManager qui pourra creer des requetes SQL
$command = new Command($contactManager);

echo "Connexion à la base de données réussie !\n\n";
// Boucle principale 
while (true) {
    $line = readline("Entrez votre commande : ");
    $line = trim($line);
    // Affiche tous les contacts de la base de données
    if ($line === 'list') {
        $command->list();
        // Affiche l'aide avec toutes les commandes disponibles
    } elseif ($line === 'help') {
        $command->help();
        // Affiche les détails d'un seul contact 
    } elseif (preg_match('/^detail\s+(\d+)$/', $line, $matches)) {
        // $matches[0] contient toute la commande "detail 42"
        // $matches[1] contient juste l'ID "42"
        $id = $matches[1];
        // Appelle la méthode detail() de Command avec l'ID extrait
        $command->detail($id);
        // Crée un nouveau contact avec les informations fournies
    } elseif (preg_match('/^create\s+"([^"]+)"\s+"([^"]+)"\s+"([^"]+)"$/', $line, $matches)) {
        // Utilise les guillemets pour isoler les informations
        // $matches[1] = nom
        // $matches[2] = email
        // $matches[3] = téléphone
        $name = $matches[1];
        $email = $matches[2];
        $phone_number = $matches[3];
        // Appelle la méthode create() avec les 3 paramètres
        $command->create($name, $email, $phone_number);
    } elseif (preg_match('/^delete\s+(\d+)$/', $line, $matches)) {
        // $matches[1] contient juste l'ID
        $id = $matches[1];
        // Appelle la méthode delete() avec l'ID
        $command->delete($id);
         // Modifie un contact existant
    } elseif (preg_match('/^modify\s+(\d+)\s+"([^"]+)"\s+"([^"]+)"\s+"([^"]+)"$/', $line, $matches)) {
        $id = $matches[1];
        $name = $matches[2];
        $email = $matches[3];
        $phone_number = $matches[4];
        $command->modify($id, $name, $email, $phone_number);
    } else {
         // Affiche un message d'erreur et invite l'utilisateur à taper "help"
        echo "Commande non reconnue. Tapez 'help' pour voir les commandes disponibles.\n";
    }

}
?>