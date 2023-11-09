<?php
    $servername = "localhost";
    $databasename = "muokkauskanta";
    $username = "root";
    $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haetaan ja sanitoidaan käyttäjän syötteet
    $userID = filter_input(INPUT_POST, "userID", FILTER_SANITIZE_NUMBER_INT);
    $newUsername = htmlspecialchars($_POST["newUsername"], ENT_QUOTES, 'UTF-8');

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Valmistellaan sql - lause
        $sql = "UPDATE users SET Username = :newUsername WHERE UserID = :userID";
        $query = $conn->prepare($sql);

        // Laitetaan parametrit paikalleen SQL lauseeseen
        $query->bindParam(":newUsername", $newUsername, PDO::PARAM_STR);
        $query->bindParam("userID", $userID, PDO::PARAM_INT);

        // Suoritetaan tietokanta haku
        $query->execute();

        // Suljetaan yhteys
        $conn = null;

        // Uudelleenohjaus kun muutos on onnistunut
        header("Location: edit_user.php?userID=" . $userID . "&success=true");
    } catch (PDOException $e)  {
        echo "Error: " . $e->getMessage();
    }
}

    // Tarkistetaan, että requestin mukana tulee GET userID
else if(isset($_GET["userID"]) && filter_var($_GET['userID'], FILTER_VALIDATE_INT)) {
    // Osittain tietokantayhteyden haun, voisilaittaa erilliseen
    // tiedostoon jota voidaan käyttää eri tiedostoissa

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
    $sql = "SELECT * FROM users WHERE UserID =  :userID";
    $kysely = $DBconn->prepare($sql);
    $kysely->bindParam(':userID', $userID, PDO::PARAM_INT);

    $kysely->execute();

    $DBconn = null; // Katkaistaan yhteys

    $user = $kysely->fetch();
    print_r($user);

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
    <h2>Muokkaa käyttäjän tietoja</h2>
    <!-- Tehdään form, jossa voidaan muokata käytäjän nimeä. form kutsuu tätä php-tiedostoa
    Käytetään POST metodia -->
    <form action="edit_user.php" method="post">
        <input type="hidden" name="userID" value="<?php echo $user['UserID']; ?>">
        <label for="newUsername">Käyttäjän nimi:</label>
        <input type="text" name="newUsername" value="<?php echo $user['Username'];?>">
        <br><br>

        <input type="submit" value="Update Information">

    </form>
    
</body>
</html>