<?php
$servername = "localhost";
$databasename = "muokkauskanta";
$username = "root";
$password = "";

try {
    $DBconn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    // new POD() tässä objektissa on tallessa teitokantayhteys

    // Virhe asetuksia
    $DBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Valmistellaa kysely
    $kysely = $DBconn->prepare("SELECT * FROM users");

    $kysely->execute();

    $DBconn = null; // Katkaistaan yhteys
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .allUsers{
            display: flex;
            justify-content: space-between;
        }

        img {
            width: 100px;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <!-- <table>
        <tr>
            <th>id</th>
            <th>Username</th>
            <th>ProfilePicture</th>
        </tr>
         <?php
    // while($rivi = $kysely->fetch()) {
    //     echo "<tr>";
    //     echo "<td>" . $rivi["UserID"] . "</td>";
    //     echo "<td>" . $rivi["Username"] . "</td>";
    // }
    ?> 
    </table> -->

    <div class="allUsers">
        <?php
        // Käydään läpi kaikki hakemisen palauttamat rivit
        while($row = $kysely->fetch()) {
            echo "<div>";
            echo "<p>" . $row["UserID"] . "</p>";
            echo "<p>" . $row[1] . "</p>";
            echo "<img src=images/". $row["ProfilePicture"] .">";
            echo "<a href='edit_user.php?userID=" . $row["UserID"] . "'>edit</a>"; // linkki muokkaus sivulle
            echo "</div>";
        }
        ?>
    </div>

</body>
</html>