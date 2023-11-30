<?php
// === tarkistetaan onko arvot samat ja onko datatyypit samat
// esim. == tulkitaan 5 ja "5" ovat sama arvo
// mutta === vertaa datatyypin myös, jolloin 5 ja "5" eivät ole sama arvo
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $username = $_POST["password"];
    $username = $_POST["email"];

    try {
        require_once 'db_connection.inc.php';
        require_once 'signup_model.inc.php'; // Model include ensin
        require_once 'signup_controller.inc.php'; // Sitten controller include
    }
    catch(PDOexception $e) {
        die("Query failed: " . $e->getMessage());
    }
} 
else {
    header("Location: ../index.php");
    die();
}

// Include tiedostoissa yleensä jätetään php:n lopetus tagi pois