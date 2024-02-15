<?php
// Si le formulaire a été soumis, traiter les données ici
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collectez les données du formulaire de réservation
    $name = $_POST['name'] ?? '';
    $pickupLocation = $_POST['pickup_location'] ?? '';
    $dropoffLocation = $_POST['dropoff_location'] ?? '';
    $pickupDate = $_POST['pickup_date'] ?? '';
    $pickupTime = $_POST['pickup_time'] ?? '';

    // TODO: Validez et nettoyez les données ici

    // TODO: Enregistrez les données de réservation dans une base de données

    // Redirigez l'utilisateur vers une page de confirmation ou affichez un message
    // header('Location: confirmation.php');
    echo "Merci pour votre réservation, $name. Un taxi vous prendra en charge à $pickupLocation.";
    // Ne pas oublier de terminer le script pour éviter d'autres traitements
    exit;
}
?>

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
        <label for="name">Votre nom :</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="pickup_location">Lieu de prise en charge :</label>
        <input type="text" id="pickup_location" name="pickup_location" required><br><br>

        <label for="dropoff_location">Destination :</label>
        <input type="text" id="dropoff_location" name="dropoff_location" required><br><br>

        <label for="pickup_date">Date de prise en charge :</label>
        <input type="date" id="pickup_date" name="pickup_date" required><br><br>

        <label for="pickup_time">Heure de prise en charge :</label>
        <input type="time" id="pickup_time" name="pickup_time" required><br><br>

        <input type="submit" value="Réserver un taxi">
    </form>
</body>

</html>