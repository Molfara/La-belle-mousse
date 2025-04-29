<?php
require_once 'vendor/autoload.php';

use MongoDB\Client;

// Paramètres de connexion à la base de données MySQL
$mysql_host = 'localhost';
$mysql_dbname = 'La_Belle_Mousse';
$mysql_username = 'root';
$mysql_password = 'Molfarka8';

// Paramètres de connexion à MongoDB
$mongo_host = 'localhost';
$mongo_port = 27017;
$mongo_dbname = 'La_Belle_Mousse';
$mongo_collection = 'testimonials';

// Connexion à MySQL avec PDO
try {
    $pdo = new PDO(
        "mysql:host=$mysql_host;dbname=$mysql_dbname;charset=utf8mb4",
        $mysql_username,
        $mysql_password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données MySQL: " . $e->getMessage());
}

// Fonction de connexion à MongoDB
function connectToMongoDB() {
    global $mongo_host, $mongo_port, $mongo_dbname, $mongo_collection;
    try {
        // Utilisation explicная класса Client
        $mongo = new Client("mongodb://$mongo_host:$mongo_port");
        $db = $mongo->$mongo_dbname;
        $collection = $db->$mongo_collection;
        
        // Test de connexion
        $testConnection = $collection->findOne();
        
        return $collection;
    } catch (Exception $e) {
        die("Erreur de connexion à MongoDB: " . $e->getMessage() . 
            "\nDétails serveur: host=$mongo_host, port=$mongo_port, db=$mongo_dbname");
    }
}
?>
