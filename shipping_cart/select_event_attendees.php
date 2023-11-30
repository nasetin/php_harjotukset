<?php

// Tällä sivulla voidaan valita osallistujia eventtiin.
// Osallistujat tallennetaan sessioon (voisi myös tallentaa tietokantaan) 
// Tämä vastaa lisäystä ostoskoriin

session_start();
//session_unset(); // Poistetaan sessiot
//session_destroy();

$host = "localhost";
    $dbname = "eventdatabase";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $pdo_conn = new PDO ("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
        $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    $query = "SELECT * FROM users";
    $stmt = $pdo_conn->prepare($query);

    $stmt->execute();

    // Nyt meillä on kaikki käyttäjät $result muuttujassa attay(array(data)...)
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null; // Suljetaan tietokanta yhteys

    // Onko jokin käyttäjä valittu
    if(isset($_POST["user_id"])) {
        $user_id = filter_var($_POST["user_id"], FILTER_VALIDATE_INT);

        if($user_id !== false && $user_id > 0) {

            // Uusi datarakenne, tehdään käyttäjästä ja sen lukumäärästä association array
            $newEventAttendee = [
                "user_id" => $user_id,
                "count" =>1, // oletuksena 1 
            ];

            $userExists = false;
            // & symboli ennen muuttujaa viittaa alkuperäiseen taulukko elementtiin,eikä luoda kopiota
            if(isset($_SESSION["users"]) && count($_SESSION["users"]) > 0){
                foreach($_SESSION["users"] as &$existingUser){
                    // Käydään läpi ennestään tallenetut eventAttendee datarakenteet
                    // ja tarkistetaan onko tällä hetkellä tallennettava id jo session taulukossa
                    if($existingUser["user_id"] === $newEventAttendee["user_id"]){
                        // Sama id löytyi
                        $existingUser["count"]++;
                        $userExists = true; // Tarvitaan tieto myöhemmin
                        break; // id löytyi, voidaan lopettaa silmukka
                    }
                }
            }

            // Luodaan sessioon tyhjä lista, vain jos sitä ei vielä ole
            if(!isset($_SESSION["users"])) {

                // Luodaan tyhjä lista
                $_SESSION["users"] = []; // Shopping cart sessio
            }

            // jos käyttäjä ei löydy, tallennetaan uusi käyttäjä sessioon
            if($userExists === false){
                $_SESSION["users"][] = $newEventAttendee;
            }

            print_r($_SESSION["users"]);
        }
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>User list</h1>

<!-- Tarkistetaan, että kysely palautti dataa -->
<?php if(count($result) > 0): ?>
    <ul>
        <?php foreach ($result as $user): ?>
        <li style="display: flex">

            <?php 
                // Estetään JavaScript koodin suoritus käyttäjän syöttämästä sisällöstä
                $userID = htmlspecialchars($user['UserID']);
                $username = htmlspecialchars($user['Username']);

            echo $user["UserID"] . " - " . $user["Username"];
            ?>

            <!-- Tulostetaan valittu lukumäärä -->
            <?php

            if(isset($_SESSION['users'])){
                foreach($_SESSION['users'] as $sessionUser){
                    if (isset($sessionUser['user_id'])
                    && $sessionUser['user_id'] == $userID) {
                        echo " - Count: " . htmlspecialchars($sessionUser['count']);
                    }
                }
            }

            ?>

            <form style="margin-left: 15px" action="select_event_attendees.php" method="post">
                <input type="hidden" name="user_id"
                value="<?php echo $userID; ?>">
                <button type="submit">Select user</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
        <p>No event found!</p>
    <?php endif; ?>
</body>
</html>