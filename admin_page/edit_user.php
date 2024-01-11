<?php 
    // Tällä sivulla saavutetaan view_users.php tiedostosta
    // Käyttäjän id saadaan GET parametrissä $_GET['UserID']

    // Sivulla näytetään valitun käyttäjän tiedot ja käyttäjä voi muokata niitä
    // Lopuksi käyttäjä voi napsauttaa "Update" -nappia, joka suorittaa
    // tietokannan päivittämisen uusilla tiedoilla.

    require_once 'db_connection.inc.php';
    require_once 'user_operations.inc.php';

    // Suoritetaan päivitys, jos saavutaab sivulle POST metodilla ja sitten uudelleen ohjataan etusivulle
    // Huom. jos päivitys epäonnistuu, käyttäjän pitää navigoida edit sivulle uudestaan ja antaa tiedot uudelleen
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['submit'])){

            $id = $_POST['Userid'];

            // Tässä luodaan association array, jossa on uusi data key=>value muodossa
            $newData = [
                'Username' => $_POST['Username'],
                'Email' => $_POST['Email'],
            ];

            // Tietokannan päivitys funktio
            updateUserDetails($pdo_conn, $id, $newData);

            header("Location: view_user.php");
            die();
        }
    }


    // Otetaan id talteen 
    if(isset($_GET['UserID'])){
        $userId = $_GET['UserID'];
        $userDetails = getUserDetails($pdo_conn, $userId);
        
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Virheiden käsittely (userid puuttuu tai käyttäjän tiedon haku ei onnistu) -->
    <h2>Edit User</h2>
    <form action="edit_user.php" method="post">
        <label for="UserID">UserID:</label>
        <input type="text" name="Userid" value="<?= $userDetails['UserID'] ?>" readonly>

        <label for="Username">Username:</label>
        <input type="text" name="Username" value="<?= htmlspecialchars($userDetails['Username']) ?>" required>

        <label for="Email">Email:</label>
        <input type="email" name="Email" value="<?= $userDetails['email'] ?>" required>

        <!-- Lopullinen datan validointi täytyy suorittaa palvelimella -->
        <!-- Käyttäjä pystyy muokkaamaan koodia / dataa omalla selaimellaan / koneellaan -->
        <!-- esimerkiksi voi poistaa required attribuutin tai email inputin => text inputtiin -->
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>