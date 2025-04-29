<?php
require_once 'config.php';

try {
    // Préparation de la requête pour récupérer les cafés disponibles
    $stmt = $pdo->query("SELECT * FROM coffee_types WHERE available = TRUE");
    
    // Récupération de tous les cafés
    $coffees = $stmt->fetchAll();
    
    // Génération HTML pour chaque café
    foreach ($coffees as $coffee) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card">';
        
        // Изображение (если есть URL)
        if (!empty($coffee['image_url'])) {
            echo '<img src="images/' . htmlspecialchars($coffee['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($coffee['name']) . '">';
        }
        
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($coffee['name']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($coffee['flavor_description']) . '</p>';
        echo '<p><strong>Origine:</strong> ' . htmlspecialchars($coffee['origin_country']) . '</p>';
        echo '<p><strong>Torréfaction:</strong> ' . htmlspecialchars($coffee['roast_level']) . '</p>';
        echo '<p><strong>Prix:</strong> ' . number_format($coffee['price_per_100g'], 2) . ' € / 100g</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} catch (PDOException $e) {
    // Gestion des erreurs
    echo "<div class='col-12 text-center'>";
    echo "<p class='text-danger'>Erreur de chargement des produits : " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
