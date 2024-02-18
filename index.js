
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("form").onsubmit = function() {
        var name = document.querySelector("#name").value;
        var phone = document.querySelector("#phone").value;
        var pickupLocation = document.querySelector("#pickup_location").value;
        var dropoffLocation = document.querySelector("#dropoff_location").value;
        var pickupDate = document.querySelector("#pickup_date").value;
        var pickupTime = document.querySelector("#pickup_time").value;

        // Validation du nom
        if (name.trim() === "") {
            alert("Le nom est requis.");
            return false; // Empêche la soumission du formulaire
        }

        // Validation du numéro de téléphone
        if (phone.trim() === "") {
            alert("Le numéro de téléphone est requis.");
            return false;
        }

        // Validation de l'adresse de prise en charge
        if (pickupLocation.trim() === "") {
            alert("L'adresse de prise en charge est requise.");
            return false;
        }

        // Validation de l'adresse de destination
        if (dropoffLocation.trim() === "") {
            alert("L'adresse de destination est requise.");
            return false;
        }

        // Validation de la date de prise en charge
        if (pickupDate.trim() === "") {
            alert("La date de prise en charge est requise.");
            return false;
        }

        // Validation de l'heure de prise en charge
        if (pickupTime.trim() === "") {
            alert("L'heure de prise en charge est requise.");
            return false;
        }

        // Si tous les champs sont valides
        return true;
    };
});

