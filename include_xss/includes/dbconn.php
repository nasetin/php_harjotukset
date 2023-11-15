<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eventdatabase";

// Salasanoja ja tunnuksia ei tallenneta koodiin
// Silloin ne ovat versio hallinnassa ja vuotavat jonnekin
// Sen sijaan environment variables, salasanat ovat erillisessa
// tiedostossa tallessa, josta ne haetaan. Eivät ole versiohallinnassa.

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

?>