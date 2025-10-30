<?php

require_once 'DBConnect.php';
require_once 'ContactManager.php';
require_once 'Command.php';

$dbConnect = new DBConnect();
$pdo = $dbConnect->getPDO();

// Créer une instance de ContactManager
$contactManager = new ContactManager($pdo);
$command = new Command($contactManager);

echo "Connexion à la base de données réussie !\n\n";

while (true) {
    $line = readline("Entrez votre commande : ");
    $line = trim($line);

    if ($line === 'list') {
        $command->list();
    } elseif ($line === 'help') {
        $command->help();
    } elseif (preg_match('/^detail\s+(\d+)$/', $line, $matches)) {
        // $matches[0] contient toute la commande "detail 42"
        // $matches[1] contient juste l'ID "42"
        $id = $matches[1];
        $command->detail($id);
    } elseif (preg_match('/^create\s+"([^"]+)"\s+"([^"]+)"\s+"([^"]+)"$/', $line, $matches)) {
        // Utilise les guillemets pour isoler les informations
        // $matches[1] = nom
        // $matches[2] = email
        // $matches[3] = téléphone
        $name = $matches[1];
        $email = $matches[2];
        $phone_number = $matches[3];
        $command->create($name, $email, $phone_number);
    } elseif (preg_match('/^delete\s+(\d+)$/', $line, $matches)) {
        // $matches[1] contient juste l'ID
        $id = $matches[1];
        $command->delete($id);
    } elseif (preg_match('/^modify\s+(\d+)\s+"([^"]+)"\s+"([^"]+)"\s+"([^"]+)"$/', $line, $matches)) {
        $id = $matches[1];
        $name = $matches[2];
        $email = $matches[3];
        $phone_number = $matches[4];
        $command->modify($id, $name, $email, $phone_number);
    } else {
        echo "Commande non reconnue. Tapez 'help' pour voir les commandes disponibles.\n";
    }

}
?>