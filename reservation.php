<?php
// Démarrer une nouvelle session ou reprendre une session existante
session_start();

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collectez les données du formulaire
    $name = $_POST['name'] ?? '';
    $pickupLocation = $_POST['pickup_location'] ?? '';
    $dropoffLocation = $_POST['dropoff_location'] ?? '';
    $pickupDate = $_POST['pickup_date'] ?? '';
    $pickupTime = $_POST['pickup_time'] ?? '';

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
        // Créez une instance PDO
        $pdo = new PDO($dsn, $user, $pass, $options);

        // Préparez une déclaration INSERT
        $stmt = $pdo->prepare('INSERT INTO reservations (name, pickup_location, dropoff_location, pickup_date, pickup_time) VALUES (?, ?, ?, ?, ?)');

        // Liez les paramètres et exécutez la déclaration pour insérer les données
        $stmt->execute([$name, $pickupLocation, $dropoffLocation, $pickupDate, $pickupTime]);

        // Stockez les données de réservation dans la session pour la confirmation
        $_SESSION['reservation_data'] = [
            'name' => $name,
            'pickup_location' => $pickupLocation,
            'dropoff_location' => $dropoffLocation,
            'pickup_date' => $pickupDate,
            'pickup_time' => $pickupTime,
        ];

        // Redirigez vers la page de confirmation
        header('Location: confirmation.php');
        exit;
    } catch (\PDOException $e) {
        // Gérez l'erreur ici
        // En production, vous devriez traiter ou enregistrer l'erreur sans afficher les détails sensibles.
        exit('Erreur de base de données : ' . $e->getMessage());
    }
} else {
    // Si le formulaire n'a pas été soumis, redirigez vers la page de réservation
    header('Location: index.php');
    exit;
}
