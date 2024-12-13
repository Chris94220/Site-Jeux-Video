<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jeux";

// Créer une connexion
$connect = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($connect->connect_error) {
    die("La connexion a échoué : " . $connect->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $numero = $_POST["telephone"];
    $adresse = $_POST["adresse"];
    $sexe = $_POST["sexe"];
    $quizz = $_POST["source"];
    $newsletter = isset($_POST["newsletter"]) ? 1 : 0; // 1 pour accepté, 0 pour non accepté

    // Hacher le mot de passe
    // Note : Il semble que vous utilisez "prenom" comme mot de passe dans votre formulaire, ce qui n'est pas correct.
    // Vous devrez ajuster cela pour que le mot de passe soit un champ séparé dans votre formulaire.
    // Exemple de mot de passe : $password = $_POST["motdepasse"];
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer la requête SQL
    $sql = "INSERT INTO user (nom, prenom, email, numero, adresse, sexe, source, newsletter) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);

    // Vérifier si la préparation a réussi
    if ($stmt === false) {
        die("Erreur lors de la préparation de la requête : " . $connect->error);
    }

    // Déterminer les types des paramètres
    $stmt->bind_param("ssissssi", $nom, $prenom, $email, $numero, $adresse, $sexe, $quizz, $newsletter);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Nouveau compte créé avec succès.";
        header("Location: index.php");
        exit(); // Ne pas oublier de terminer le script après redirection
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
}

$connect->close();
