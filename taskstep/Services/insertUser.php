<?php
// Configuration de la base de données
$host = 'localhost'; 
$db = 'taskstepnew';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';


// DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    // Connexion
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");

    // Définir les valeurs à insérer
    $email = 'tata@gmail.com';
    $password = password_hash('toto', PASSWORD_DEFAULT); // Hachage du mot de passe

    // Exécuter la requête
    $stmt->execute(['email' => $email, 'password' => $password]);

    echo "Données insérées avec succès.";
} catch (\PDOException $e) {
    echo "Erreur lors de l'insertion : " . $e->getMessage();
}
?>