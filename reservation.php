<?php
// Démarrer une nouvelle session ou reprendre une session existante
session_start();

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collectez les données du formulaire
    $name = $_POST['name'] ?? null;
    $pickupLocation = $_POST['pickup_location'] ?? null;
    $dropoffLocation = $_POST['dropoff_location'] ?? null;
    $pickupDate = $_POST['pickup_date'] ?? null;
    $pickupTime = $_POST['pickup_time'] ?? null;
    // TODO: Validez et nettoyez les données ici (très important pour la sécurité)

    // Paramètres de connexion à la base de données
    $host = '127.0.0.1';
    $db = 'taxi_reservation_db';
    $user = 'db_user';
    $pass = 'db_pass';
    $charset = 'utf8mb4';

    // Chaîne de connexion (DSN)
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=taxi_reservation_db', 'root', '');
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        // Requête d'insertion préparée
        $stmt = $pdo->prepare("INSERT INTO reservations (name, pickup_location, dropoff_location, pickup_date, pickup_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $pickupLocation, $dropoffLocation, $pickupDate, $pickupTime]);

        // Stocker les données pour confirmation
        $_SESSION['reservation'] = [
            'name' => $name,
            'pickup_location' => $pickupLocation,
            'dropoff_location' => $dropoffLocation,
            'pickup_date' => $pickupDate,
            'pickup_time' => $pickupTime,
            // 'confirmation_number' => $pdo->lastInsertId() // Optionnel: récupérer le numéro de confirmation
        ];

        // Redirection vers la page de confirmation
        header('Location: confirmation.php');
        exit;
    } catch (PDOException $e) {
        // Gestion des erreurs
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
} else {
    // Redirection si la page est accédée sans soumission de formulaire
    header('Location: index.php');
    exit;
}
