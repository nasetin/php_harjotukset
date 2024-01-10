<?php

// Tässä tiedostossa listataan kaikki käyttäjät taulukossa
// Taulukossa on napit, joilla käyttäjä voidaan poistaa tai muokata

// 1. Haetaan käyttäjien tiedot
//      a. tietokanta yhteys (erillinen tiedosto)
//      b. SQL lause ja sen suoritus ja siitä datan haku
//
// 2. Generoidaan käyttöliittymä haetun datan perusteella
//
// 3. Lisätään tyylittelyjä
//
// 4. Lisätään käyttäjän poisto toiminnallisuus "delete" napille
//      a. if, joka tarkistaa, että "delete" löytyy $_POST muuttujasta
//      b. SQL DELETE komento tietokantaan käyttäjän id:llä
//      c. ei DELETE vaan lisätään delete_at sarake ja PVM milloin käyttäjä poistettiin
//
// 5. Näytetään käyttöliittymässä, mitkä käyttäjät on poistettu
//      a. tietokannasta pitää hakea sarake, jossa tieto poistosts "deleted_at"-sarake
//      b. lisätään jokin tyyli riveille, joiden käyttällä "deleted_at" !=null
//
// 6. Lisätään käyttäjän palautus painike
//      a. Lisätään valintarakkenne, jossa genetoidaan joko....

// Tietokanta yhteyden koodit löytyy tästä tiedostosta
require_once 'db_connection.inc.php'; // <- $pdo_conn
require_once 'user_operations.inc.php';

// Käyttäjän "poisto"
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['delete'])){
        // delete nappia on painettu
        $useridToDelete = $_POST["user_id"];
       $operationResult = delete_user($pdo_conn, $useridToDelete);
    }
}

// Käyttäjän "palautus"
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['restore'])){
        // restore nappia on painettu
        $useridToRestero = $_POST["user_id"];
       $operationResult = restore_user($pdo_conn, $useridToRestero);
    }
}
// $queryString = "SELECT * FROM users" // Voi olla myös erillinen muuttuja SQL lauseelle
$stmt = $pdo_conn->prepare("SELECT UserID, Username, email, deleted_at FROM users");

$stmt->execute(); // Suotitetaan SQL lause
$users = $stmt->fetchALL(PDO::FETCH_ASSOC); // Tallennetaan data muuttujaan


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Users</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #d2d2d2;
        }

        body{
            display: flex;
            justify-content: center;
        }

        h2 {
            text-align: center;
        }

        .delete {
            background-color: #f5514e;
            font-weight: bold;
            padding: 15px;
            border-radius: 15px;
            cursor: pointer;
        }

        form {
            display: inline-flex;
        }

        .padding {
            width: 25px;
            display: inline-flex;
        }

        a {
            display: inline-flex;
        }

        .deleted {
            background-color: #FFD2D2;
        }

        .restore {
            background-color: #8ced28;
        }

        .hidden {
            opacity: 0;
        }

    </style>
</head>
<body>

        <main>

        <h3 <?php if(isset($operationResult) === false) { echo "class='hidden'"; } ?> > <?php if(isset($operationResult)) { echo $operationResult; } else { echo "hidden";} ?>  </h3>            
            <h2>User List</h2>
            
            <!-- Tähän taulukkoon generoidaan rivejä $users muuttujan datan perusteella -->
            <table>
                <!-- Otsikko rivi -->
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                <!-- Loopataan läpi $users array ja generoidaan rivejä taulukkoon -->
                <?php foreach($users as $user): ?>
                    
                    <!-- Uusi user rivi alkaa -->
                    <tr <?php if ( $user['deleted_at'] !== null ) echo "class='deleted'"; ?> >
                        
                        <!-- <td><?php // echo $user["UserID"]; ?></td> -->
                        <td><?= $user["UserID"] ?></td><!-- td on rivin sarakkeita -->
                        <td><?= htmlspecialchars($user["Username"]) ?></td>
                        <td><?= htmlspecialchars($user["email"]) ?></td>
                        <td>  <!-- Action sarake -->

                        <?php if($user['deleted_at'] === null): ?>
                        <!-- Poistetaan käyttäjä tällä sivulla -->
                        <form action="view_user.php" method ="post">
                            <input type="hidden" name="user_id" value="<?= $user["UserID"] ?>">
                            <button class="delete" name="delete" type="submit">Delete</button>
                            <!-- isset($_POST["delete"]) ja $_POST["user_id] -->
                        </form>

                        <?php else: ?>
                            <form action="view_user.php" method ="post">
                            <input type="hidden" name="user_id" value="<?= $user["UserID"] ?>">
                            <button class="restore" name="restore" type="submit">Restore</button>
                        </form> 
                        <?php endif; ?>
                        
                        <div class="padding"></div>

                        <!-- $_GET["userid"] -->
                        <a href="edit_user.php?UserID=<?= $user["UserID"] ?>">Edit</a>
                        
                    </td> <!-- Action sarake -->
                </tr> <!-- user rivi päättyy -->
                
                <?php endforeach; ?>
            </table>
        </main>
        </body>
        </html>