<?php
require_once 'config.php';

// Vérification des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage et validation des données
    $full_name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = trim($_POST['phone']);
    $coffee_type_id = intval($_POST['coffee']);
    $quantity = intval($_POST['quantity']);

    // Validation des données
    $errors = [];
    if (empty($full_name)) $errors[] = "Nom requis";
    if (!$email) $errors[] = "Email invalide";
    if (empty($phone)) $errors[] = "Numéro de téléphone requis";
    if ($coffee_type_id <= 0) $errors[] = "Café non sélectionné";
    if ($quantity <= 0) $errors[] = "Quantité invalide";

    if (empty($errors)) {
        try {
            // Préparation de la requête d'insertion
            $stmt = $pdo->prepare("INSERT INTO orders 
                (full_name, email, phone, coffee_type_id, quantity_grams) 
                VALUES (?, ?, ?, ?, ?)");
            
            // Exécution de la requête
            $result = $stmt->execute([
                $full_name, 
                $email, 
                $phone, 
                $coffee_type_id, 
                $quantity
            ]);

            if ($result) {
                // Redirection avec message de succès
                header("Location: confirmation.php?status=success");
                exit();
            } else {
                // Erreur lors de l'insertion
                header("Location: confirmation.php?status=error");
                exit();
            }
        } catch (PDOException $e) {
            // Gestion des erreurs de base de données
            error_log("Erreur de commande: " . $e->getMessage());
            header("Location: confirmation.php?status=error&message=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        // S'il y a des erreurs de validation
        $error_message = implode(", ", $errors);
        header("Location: index.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // Accès direct au script non autorisé
    header("Location: index.php");
    exit();
}
?>
