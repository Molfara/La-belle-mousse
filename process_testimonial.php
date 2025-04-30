<?php
require_once 'config.php';

// Fichier pour journaliser les erreurs
$log_file = 'testimonial_log.txt';

// Écriture dans le journal pour débogage
file_put_contents($log_file, date('Y-m-d H:i:s') . ' - Formulaire soumis' . PHP_EOL, FILE_APPEND);
file_put_contents($log_file, print_r($_POST, true) . PHP_EOL, FILE_APPEND);

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données du formulaire
    $customer_name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $testimonial_type = isset($_POST['type']) ? $_POST['type'] : 'coffee';
$testimonial_text = isset($_POST['text']) ? trim($_POST['text']) : '';
    
    // Validation simple
    $errors = [];
    
    if (empty($customer_name)) {
        $errors[] = 'Le nom est obligatoire';
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = 'La note doit être entre 1 et 5';
    }
    
    if (empty($testimonial_text)) {
        $errors[] = 'Le témoignage est obligatoire';
    }
    
    // Écriture des résultats de validation dans le journal
    file_put_contents($log_file, 'Résultats de validation: ' . (empty($errors) ? 'OK' : implode(', ', $errors)) . PHP_EOL, FILE_APPEND);
    
    // S'il n'y a pas d'erreurs, sauvegarde du témoignage dans MongoDB
    if (empty($errors)) {
        try {
            // Connexion à MongoDB
            file_put_contents($log_file, 'Connexion à MongoDB...' . PHP_EOL, FILE_APPEND);
            
            // Utilisation des paramètres corrects pour Docker
            $mongo_host = 'mongo'; // Nom du service dans docker-compose
            $mongo_port = 27017;
            $mongo_dbname = 'La_Belle_Mousse';
            $mongo_collection = 'testimonials';
            
            // Création de la connexion directement ici pour garantir l'utilisation des bons paramètres
            $mongo = new MongoDB\Client("mongodb://$mongo_host:$mongo_port");
            $db = $mongo->$mongo_dbname;
            $collection = $db->$mongo_collection;
            
            file_put_contents($log_file, 'Connexion à MongoDB réussie' . PHP_EOL, FILE_APPEND);
            
            // Création du document à insérer
            $document = [
                'customer_name' => $customer_name,
                'rating' => $rating,
                'testimonial_type' => $testimonial_type,
                'testimonial_text' => $testimonial_text,
                'created_at' => new MongoDB\BSON\UTCDateTime(time() * 1000),
                'approved' => true // Approuvé par défaut, peut être changé à false si modération nécessaire
            ];
            
            // Enregistrement du document dans le journal
            file_put_contents($log_file, 'Document à insérer: ' . print_r($document, true) . PHP_EOL, FILE_APPEND);
            
            // Insertion du document
            $result = $collection->insertOne($document);
            
            // Vérification du résultat
            if ($result->getInsertedCount() > 0) {
                file_put_contents($log_file, 'Témoignage enregistré avec succès. ID: ' . $result->getInsertedId() . PHP_EOL, FILE_APPEND);
                
                // Redirection vers la page d'accueil avec un message de succès
                header('Location: index.php?testimonial_success=1');
                exit;
            } else {
                file_put_contents($log_file, 'Échec de l\'enregistrement du témoignage. Aucun document inséré.' . PHP_EOL, FILE_APPEND);
                $errors[] = 'Erreur lors de l\'enregistrement du témoignage';
            }
        } catch (Exception $e) {
            file_put_contents($log_file, 'Exception: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
            $errors[] = 'Erreur de connexion à la base de données: ' . $e->getMessage();
        }
    }
    
    // S'il y a des erreurs, redirection avec un message d'erreur
    if (!empty($errors)) {
        $error_string = implode(', ', $errors);
        header('Location: index.php?testimonial_error=' . urlencode($error_string));
        exit;
    }
} else {
    // Si le formulaire n'a pas été soumis par la méthode POST
    file_put_contents($log_file, 'Formulaire non soumis avec la méthode POST' . PHP_EOL, FILE_APPEND);
    header('Location: index.php');
    exit;
}
?>
