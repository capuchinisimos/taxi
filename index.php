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
    <title>BTS ALLIANCE TAXIS</title>
    <!-- Insérez ici les styles CSS ou les liens externes si nécessaire -->
</head>
<body>

<header>
    <img src="bts.jpg" alt="logo">
<h1>BTS ALLIANCE TAXIS</h1>
</header>
<main>
    <h2>FORMULAIRE DE RESERVATION DE TAXI EN LIGNE</h2>
    <form action="reservation.php" method="post">
       <div>
      <label for="name"> Nom complet :</label>
      <input type="text" id="name" name="name" required>
       </div>
       <div>
        <label for="phone">Numéro de téléphone :</label>
        <input type="tel" id="phone" name="phone" required>
       </div>
       <div>
        <label for="pickup_location">Adresse de prise en charge :</label>
        <input type="text" id="pickup_location" name="pickup_location" required>
       </div>
       <div>
        <label for="dropoff_location">Adresse de destination :</label>
        <input type="text" id="dropoff_location" name="dropoff_location"required>
       </div>
<div>
    <label for="pickup_date"> Date de prise en charge :</label>
    <input type="date" id="pickup_date" name="pickup_date" required>
</div>
<div>
<label for="pickup_time"> Heure de prise en charge</label>
<input type="time" id="pickup_time" name="pickup_time" required>
</div>
<div>
    <label for="comments"> Commentaires additionnels :</label>
    <textarea name="comments" id="comments"></textarea>
</div>
<div>
<input type="submit" value="Reserver un taxi"></div>
    </form>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("form").onsubmit = function() {
        var name = document.querySelector("#name").value;
        if (name.trim() === "") {
            alert("Le nom est requis.");
            return false; // Empêche la soumission du formulaire
        }
        // Ajoutez ici d'autres validations si nécessaire
        return true; // Permet la soumission du formulaire
    };
});
</script>

</body>
</html>
