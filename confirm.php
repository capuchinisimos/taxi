<?php
// Démarrer la session pour accéder aux données de la session
session_start();

// Vérifier si les données de réservation existent dans la session
if (!isset($_SESSION['reservation_data'])) {
    // Si aucune donnée de réservation n'est disponible, rediriger vers la page de réservation
    header('Location: index.php');
    exit;
}

// Récupérer les données de réservation de la session
$reservationData = $_SESSION['reservation_data'];

// Effacer les données de réservation de la session après leur récupération
unset($_SESSION['reservation_data']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation de Réservation de Taxi</title>
    <!-- Insérez ici les styles CSS ou les liens externes si nécessaire -->
</head>

<body>
    <h1>Confirmation de votre réservation</h1>
    <p>Merci, <?php echo htmlspecialchars($reservationData['name']); ?>. Votre taxi a été réservé avec succès.</p>
    <p>Voici les détails de votre réservation :</p>
    <ul>
        <li>Lieu de prise en charge: <?php echo htmlspecialchars($reservationData['pickup_location']); ?></li>
        <li>Destination: <?php echo htmlspecialchars($reservationData['dropoff_location']); ?></li>
        <li>Date: <?php echo htmlspecialchars($reservationData['pickup_date']); ?></li>
        <li>Heure: <?php echo htmlspecialchars($reservationData['pickup_time']); ?></li>
    </ul>
    <p>Nous vous enverrons un taxi à l'adresse de prise en charge spécifiée le jour de votre réservation.</p>
</body>

</html>