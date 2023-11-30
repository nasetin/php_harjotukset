<?php

    // Tässä projektissa valitaan tietty event
    // sen jälkeen valitaan osallistujia tietokannasta
    // tallennetaan osallistujat talteen sessioon
    // koodia voi soveltaa verkkokaupan ostoskoria varten

    // Tässä tiedostossa listataan tietokannasta kaikki eventit
    // ja käyttäjä valitsee yhden. käyttäjän valitsema eventid
    // tallennetaan sessioon. (eventID on verrattavissa verkkokaipan userID)

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

    $query = "SELECT * FROM events";
    $stmt = $pdo_conn->prepare($query);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // $result = []; kokeiltiin else osiota tyhjällä taulukolla

    print_r($result);

    $pdo_conn = null; // suljetaan yhteys


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Event list</h1>

    <!-- Tarkistetaan, että kysely palautti dataa -->
    <?php if(count($result) > 0): ?>
        <ul>
            <?php foreach ($result as $event): ?>
            <li style="display: flex">
                <?php echo $event["EventID"] . " - " . $event["EventName"]
                . " - " . $event["EventDate"];?>
                <form style="margin-left: 15px" action="begin_event_attendees.php" method="post">
                    <input type="hidden" name="event_id"
                    value="<?php echo $event["EventID"]; ?>">
                    <button type="submit">Select Event</button>
                </form>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
            <p>No event found!</p>
        <?php endif; ?>
</body>
</html>