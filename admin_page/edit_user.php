<?php 
    // Tällä sivulla saavutetaan view_users.php tiedostosta
    // Käyttäjän id saadaan GET parametrissä $_GET['UserID']

    // Sivulla näytetään valitun käyttäjän tiedot ja käyttäjä voi muokata niitä
    // Lopuksi käyttäjä voi napsauttaa "Update" -nappia, joka suorittaa
    // tietokannan päivittämisen uusilla tiedoilla.

    require_once 'db_connection.inc.php';
    require_once 'user_operations.inc.php';

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
        <input type="text" value="<?= $userDetails['UserID'] ?>";>

        <label for="Username">Username:</label>
        <input type="text" name="Username" value="<?= $userDetails['Username'] ?>";>

    </form>
</body>
</html>