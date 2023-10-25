<?php

// Palvelimen nimi muuttujaan
$servername ="localhost";
$username ="root"; // Tarkistetaan phpmyadmin sivulta käyttäjät
$password =""; // Tarkistetaan phpmyadmin sivulta käyttäjät

// Yritetään
try{
    // Luodaan yhteys, joka on PDO objekti
    $conn = new PDO("mysql:host=$servername;dbname=eventdatabase", $username, $password);

    // PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // isolla, koska ovat constant arvoja
    echo "Toimi!";
}
catch(PDOException $e){
    // Yhteysepäonnistui
    echo "Connection failed: " . $e->getMessage();
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>