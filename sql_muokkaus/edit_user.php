<?php
// Tarkistetaan, että requestin mukana tulee GET userID
if(isset($_GET["userID"]) && filter_var($_GET['userID'], FILTER_VALIDATE_INT)) {
    // Osittain tietokantayhteyden haun, voisilaittaa erilliseen
    // tiedostoon jota voidaan käyttää eri tiedostoissa
$servername = "localhost";
$databasename = "muokkauskanta";
$username = "root";
$password = "";

$userID = $_GET['userID'];

try {
    $DBconn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    // new POD() tässä objektissa on tallessa teitokantayhteys

    // Virhe asetuksia
    $DBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Valmistellaa kysely
    // SQL injection harjoitus
    echo "SELECT * FROM users WHERE UserID =  $userID";
    // $kysely = $DBconn->prepare("SELECT * FROM users WHERE UserID =  $userID");

    // Toinen tapa välttää SQL injection
    $sql = "SELECT * FROM users WHERE UserID =  $userID";
    $kysely = $DBconn->prepare($sql);
    $kysely->bindParam(':userID', $userID, PDO::PARAM_INT);

    $kysely->execute();

    $DBconn = null; // Katkaistaan yhteys

    echo print_r($kysely->fetch());

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
}else{
    // Siirretään käyttäjä takaisin
    header("Location: index.php?error=true");
    exit(); // Lopetetaan tiedoston suoritus
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