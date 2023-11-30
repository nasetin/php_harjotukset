<?php
// Tietokannan käyttö tässä tiedostossa
// Vain controller tiedosto käyttää tätä model tiedostoa

declare(strict_types= 1);

// Funktio hakee tietokannasta parametrinä saadun käyttäjänimen
// Tietokanta yhteys objecti PDO, saadaan parametrinä/argumenttinä signup tiedostosta
function get_username(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username= :username";
    // stmt = statement lyhennettynä
    $stmt = $pdo->prepare($query);
    // bindParam = syötetään käyttäjän data (username) SQL kyselyyn tavalla, joka estää
    // SQL injektion
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    // hakee rivin dataa suoritetusta hausta (fetch). palauttaa datan
    // associate arrays muodossa "sarakkeen_nimi" => arvo (FETCH_ASSOC)
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result; // Saadaan palautuksena joko käyttäjänimi tai false (jos dataa ei löytynyt)
}

// Haetaan käyttäjä. Jolla on tietty sähköpostiosoite

function get_email(object $pdo, string $email) {
    $query = "SELECT username FROM users WHERE email= :email";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam("email", $email);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function set_user(object $pdo, string $username, string $password, string $email) {
    $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :passwd, :email)";

    $stmt = $pdo->prepare($query);

    // Hash algoritmin laskennallinen hinta, isompi luku => monimutkaisempi salasana
    $options = ["cost" => 12];

    // Salasana häshätään muotoon, jota ei voida lukea. 
    // Ideana on algoritmi muuttaa saman salasana aina samaan muotoon.
    // Näin meidän ei tarvitse tietää mikä käyttäjän salasana on, riittää
    // että vertaamme käyttäjän syöttämää salasanaa häshättynä siihen, 
    // mikä meillä on tiedossa.
    $hashedpwd = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->bindParam("username", $username);
    $stmt->bindParam("password", $hashedpwd);
    $stmt->bindParam("email", $email);

    $stmt->execute();
}