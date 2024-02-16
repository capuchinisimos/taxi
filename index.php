<?php
session_start(); // Commencez par démarrer une session

// Si le formulaire a été soumis, traiter les données ici
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collectez les données du formulaire de réservation
    $name = trim($_POST['name']);
    $pickupLocation = trim($_POST['pickup_location']);
    $dropoffLocation = trim($_POST['dropoff_location']);
    $pickupDate = trim($_POST['pickup_date']);
    $pickupTime = trim($_POST['pickup_time']);

    // Validez et nettoyez les données ici
    $errors = [];
    // Vous pouvez ajouter des validations plus spécifiques ici
    if (empty($name)) $errors[] = "Le nom est requis.";
    if (empty($pickupLocation)) $errors[] = "Le lieu de prise en charge est requis.";
    if (empty($dropoffLocation)) $errors[] = "La destination est requise.";
    if (empty($pickupDate)) $errors[] = "La date de prise en charge est requise.";
    if (empty($pickupTime)) $errors[] = "L'heure de prise en charge est requise.";

    // S'il n'y a pas d'erreurs, procédez à l'enregistrement des données
    if (empty($errors)) {
        // Incluez votre fichier de configuration pour la connexion à la base de données
        require 'config.php';

        try {
            $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO reservations (name, pickup_location, dropoff_location, pickup_date, pickup_time) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $pickupLocation, $dropoffLocation, $pickupDate, $pickupTime]);

            // Stockez les données de réservation dans la session pour la confirmation
            $_SESSION['reservation_data'] = [
                'name' => $name,
                'pickup_location' => $pickupLocation,
                'dropoff_location' => $dropoffLocation,
                'pickup_date' => $pickupDate,
                'pickup_time' => $pickupTime
            ];

            // Redirigez l'utilisateur vers une page de confirmation
            header('Location: confirmation.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Erreur de base de données : " . $e->getMessage();
        }
    }
    
    // Si des erreurs se produisent, stockez-les dans la session pour les afficher plus tard
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }
}
?>
<?php if (!empty($_SESSION['errors'])): ?>
    <ul>
        <?php foreach ($_SESSION['errors']
as $error): ?>
<li><?php echo htmlspecialchars($error); ?></li>
<?php endforeach; ?>
<?php unset($_SESSION['errors']); // Nettoyez les erreurs après les avoir affichées ?>
</ul>

<?php endif; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation de Taxi</title>
    <!-- Insérez ici les styles CSS ou les liens externes si nécessaire -->
</head>
<body>
    <h1>Réservez votre Taxi</h1>
    <form action="index.php" method="post">
        <!-- Les champs du formulaire ici -->
        <!-- ... -->
    </form>
</body>
</html>
