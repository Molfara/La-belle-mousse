<?php
require_once 'config.php';

try {
    // Préparation de la requête pour récupérer les noms des cafés
    $stmt = $pdo->query("SELECT id, name FROM coffee_types WHERE available = TRUE");
    
    // Récupération de tous les cafés
    $coffees = $stmt->fetchAll();
    
    // Génération des options pour le select
    foreach ($coffees as $coffee) {
        echo "<option value='" . htmlspecialchars($coffee['id']) . "'>" 
             . htmlspecialchars($coffee['name']) . "</option>";
    }
} catch (PDOException $e) {
    // Gestion des erreurs
    echo "<option>Erreur de chargement des cafés</option>";
}
?>
