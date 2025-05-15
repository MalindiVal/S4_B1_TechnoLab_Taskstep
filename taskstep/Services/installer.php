<?php
require_once("../Config/Config.php");

if (!extension_loaded('pdo_mysql')) {
    die("Erreur : L'extension PDO MySQL est requise.\n");
}

function installerBase(PDO $pdo, string $host, string $dbname, string $user, string $password, ?string $dsn): void {
    $schema_file = __DIR__ . '/taskstep.sql';

    if (file_exists($schema_file)) {
        $pdo->exec(file_get_contents($schema_file));
        echo "Schéma importé depuis '$schema_file'.\n";
    }

    // Si aucun DSN défini, alors on génère le fichier de config
    if (!$dsn) {
        $config_content = <<<INI
; config dev
[DB]
dsn = mysql:host=$host;dbname=$dbname;charset=utf8
user = $user
pass = $password
INI;

        file_put_contents(__DIR__ . '/Config/dev.ini', $config_content);
        echo "Fichier de configuration 'dev.ini' créé avec succès.\n";
    }

    echo "<a href='index.php'>Retour à l'acceuil</a>";
}

// Récupération des valeurs depuis la config ou le formulaire
$host = $_POST['host'] ?? 'localhost';
$dbname = $_POST['dbname'] ?? null;  // Pour le cas POST
$user = $_POST['user'] ?? Config::get('user');
$password = $_POST['password'] ?? Config::get('pass');
$dsn = Config::get('dsn');

try {
    // Si la config est bien remplie, on tente une connexion directe
    if ($dsn && $user) {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        echo "Connexion réussie à MySQL.\n";

        // On extrait dbname du DSN pour le transmettre
        preg_match('/dbname=([^;]+)/', $dsn, $matches);
        
        $dbname_from_dsn = $matches[1] ?? '';

        installerBase($pdo, $host, $dbname_from_dsn, $user, $password, $dsn);
    } else {
        throw new Exception("Configuration DSN incomplète");
    }
} catch (Exception $e) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $pdo = new PDO("mysql:host=$host", $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Création de la base si elle n'existe pas
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
            $pdo->exec("USE `$dbname`");

            installerBase($pdo, $host, $dbname, $user, $password, null);
        } catch (PDOException $e) {
            die("Erreur PDO : " . $e->getMessage());
        }
    } else {
        // Affichage du formulaire si en mode GET
        echo '<form method="POST">
                <label>Hôte :</label><input type="text" name="host" value="localhost"><br>
                <label>Base de données :</label><input type="text" name="dbname"><br>
                <label>Utilisateur :</label><input type="text" name="user"><br>
                <label>Mot de passe :</label><input type="password" name="password"><br>
                <button type="submit">Installer</button>
            </form>';
        exit;
    }
}
