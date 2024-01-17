<?php

require 'secrets.php';

try {
    $pdo_conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Toimii"; // Kokeilua varten
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
