<?php
require_once 'config.php';

try {
    // Connexion à la base de données MongoDB
    $collection = connectToMongoDB();

    // Recherche des témoignages approuvés, triés par date (les plus récents en premier)
    $testimonials = $collection->find([
        'approved' => true
    ], [
        'sort' => ['created_at' => -1],
        'limit' => 6 // Limite du nombre de témoignages
    ]);

    // Génération du HTML pour les témoignages
    foreach ($testimonials as $testimonial) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card testimonial-card h-100">';
        echo '<div class="card-body d-flex flex-column">';

        // Affichage de la notation en étoiles
        echo '<div class="rating mb-3">';
        for ($i = 1; $i <= 5; $i++) {
            echo $i <= $testimonial['rating']
                ? '<span class="star text-warning">★</span>'
                : '<span class="star text-muted">★</span>';
        }
        echo '</div>';

        // Texte du témoignage
        echo '<p class="card-text flex-grow-1 mb-3">"' . htmlspecialchars($testimonial['testimonial_text']) . '"</p>';

        // Nom de l'auteur et type de témoignage
        echo '<div class="testimonial-footer mt-auto">';
        echo '<p class="card-text mb-0"><small class="text-muted">';
        echo htmlspecialchars($testimonial['customer_name']);
        echo ' - ' . ($testimonial['testimonial_type'] === 'service' ? 'Service' : 'Café');
        echo '</small></p>';
        echo '</div>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} catch (Exception $e) {
    // Gestion des erreurs
    echo "<div class='col-12 text-center'>";
    echo "<p class='text-danger'>Erreur de chargement des témoignages : " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
