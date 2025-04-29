<?php
// Connexion au client MongoDB
try {
    // Créer une connexion au serveur MongoDB
    $mongo = new MongoDB\Client("mongodb://localhost:27017");

    // Créer la base de données La_Belle_Mousse
    $database = $mongo->La_Belle_Mousse;

    // Créer la collection testimonials
    $testimonials = $database->testimonials;

    // Définir des options de validation pour la collection
    $database->createCollection('testimonials', [
        'validator' => [
            '$jsonSchema' => [
                'bsonType' => 'object',
                'required' => ['customer_name', 'rating', 'testimonial_type', 'testimonial_text', 'created_at'],
                'properties' => [
                    'customer_name' => [
                        'bsonType' => 'string',
                        'description' => 'Nom du client qui laisse un témoignage'
                    ],
                    'rating' => [
                        'bsonType' => 'int',
                        'minimum' => 1,
                        'maximum' => 5,
                        'description' => 'Note de 1 à 5'
                    ],
                    'testimonial_type' => [
                        'enum' => ['service', 'coffee'],
                        'description' => 'Type de témoignage'
                    ],
                    'testimonial_text' => [
                        'bsonType' => 'string',
                        'description' => 'Texte du témoignage'
                    ],
                    'created_at' => [
                        'bsonType' => 'date',
                        'description' => 'Date de création du témoignage'
                    ],
                    'approved' => [
                        'bsonType' => 'bool',
                        'description' => 'Statut d\'approbation du témoignage'
                    ]
                ]
            ]
        ]
    ]);

    // Insérer des témoignages de démonstration
    $testimonials->insertMany([
        [
            'customer_name' => 'Marie Dupont',
            'rating' => 5,
            'testimonial_type' => 'coffee',
            'testimonial_text' => 'Un café absolument délicieux ! Je recommande vivement La Belle Mousse.',
            'created_at' => new MongoDB\BSON\UTCDateTime(),
            'approved' => true
        ],
        [
            'customer_name' => 'Jean Martin',
            'rating' => 4,
            'testimonial_type' => 'service',
            'testimonial_text' => 'Livraison rapide et service client impeccable.',
            'created_at' => new MongoDB\BSON\UTCDateTime(),
            'approved' => true
        ],
        [
            'customer_name' => 'Sophie Leroy',
            'rating' => 5,
            'testimonial_type' => 'service',
            'testimonial_text' => 'Un service client extraordinaire, toujours à l\'écoute et très professionnel. Je recommande La Belle Mousse à tous les amateurs de café !',
            'created_at' => new MongoDB\BSON\UTCDateTime(),
            'approved' => true
        ],
        [
            'customer_name' => 'Pierre Dubois',
            'rating' => 4,
            'testimonial_type' => 'coffee',
            'testimonial_text' => 'J\'ai découvert des saveurs incroyables avec leurs cafés. Le Blend Signature est devenu mon café du matin préféré.',
            'created_at' => new MongoDB\BSON\UTCDateTime(),
            'approved' => true
        ],
        [
            'customer_name' => 'Amélie Martin',
            'rating' => 5,
            'testimonial_type' => 'coffee',
            'testimonial_text' => 'Le café Ethiopian Yirgacheffe est une véritable découverte gustative. Des notes florales et fruitées absolument exceptionnelles !',
            'created_at' => new MongoDB\BSON\UTCDateTime(),
            'approved' => true
        ]
    ]);

    echo "Base de données MongoDB La_Belle_Mousse créée avec succès !";
} catch (Exception $e) {
    echo "Erreur lors de la création de la base de données : " . $e->getMessage();
}
?>
