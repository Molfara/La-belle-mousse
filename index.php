<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La belle mousse - Boutique en ligne de cafés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Section d'accueil -->
    <header class="hero-section">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">La belle mousse</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#about">À propos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#selection">Notre sélection</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#order">Commander</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#testimonials">Témoignages</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row hero-content">
                <div class="col-md-8 offset-md-2 text-center">
                    <h1>Boutique en ligne de cafés</h1>
                    <h2 class="brand-name">"La belle mousse"</h2>
                    <p class="lead">Livraison en France</p>
                    <a href="#selection" class="btn btn-primary btn-lg">Découvrir nos cafés</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Section À propos -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h2 class="section-title">À propos de nous</h2>
                    <p class="section-description">
                        Fondée en 2020, La belle mousse est née d'une passion pour le café d'exception. Notre mission est de vous faire découvrir les meilleurs cafés du monde, soigneusement sélectionnés et torréfiés à la perfection.
                    </p>
                    <p class="section-description">
                        Nous travaillons directement avec des producteurs respectueux de l'environnement et des communautés locales, pour vous garantir un café de qualité supérieure, tout en soutenant des pratiques durables.
                    </p>
                    <p class="section-description">
                        Chaque grain de café que nous proposons est torréfié avec soin par nos maîtres torréfacteurs, pour vous offrir une expérience gustative exceptionnelle.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Notre sélection -->
    <section id="selection" class="selection-section">
        <div class="container">
            <h2 class="section-title">Notre sélection</h2>
            <p class="section-description">
                Découvrez notre gamme de cafés d'exception, provenant des quatre coins du monde.
            </p>
            <div class="row coffee-list">
                <!-- Les produits seront chargés dynamiquement ici via PHP/MySQL -->
                <?php include 'get_products.php'; ?>
            </div>
        </div>
    </section>

    <!-- Section Commander -->
    <section id="order" class="order-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h2 class="section-title">Passer une commande</h2>
                    <form id="orderForm" action="process_order.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom et prénom</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="coffee" class="form-label">Choisir un café</label>
                            <select class="form-select" id="coffee" name="coffee" required>
                                <option value="">Sélectionnez un café</option>
                                <?php include 'get_coffee_options.php'; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantité (en grammes)</label>
                            <select class="form-select" id="quantity" name="quantity" required>
                                <option value="250">250g</option>
                                <option value="500">500g</option>
                                <option value="1000">1kg</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Commander</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Témoignages -->
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <h2 class="section-title">Témoignages</h2>
            <div class="row testimonials-container">
                <!-- Les témoignages seront chargés dynamiquement ici via PHP/MongoDB -->
                <?php include 'get_testimonials.php'; ?>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h3>Partagez votre expérience</h3>
                    <form id="testimonialForm" action="process_testimonial.php" method="POST">
                        <div class="mb-3">
                            <label for="testimonialName" class="form-label">Votre nom</label>
                            <input type="text" class="form-control" id="testimonialName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Note (1-5)</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Très bien</option>
                                <option value="3">3 - Bien</option>
                                <option value="2">2 - Moyen</option>
                                <option value="1">1 - Décevant</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="testimonialType" class="form-label">Type de témoignage</label>
                            <select class="form-select" id="testimonialType" name="type" required>
                                <option value="service">Service</option>
                                <option value="coffee">Café</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="testimonialText" class="form-label">Votre témoignage</label>
                            <textarea class="form-control" id="testimonialText" name="text" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2025 La belle mousse - Tous droits réservés</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
