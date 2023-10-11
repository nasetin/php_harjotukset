<?php
session_start(); // Tarvitaan sessioita varten
// GET vai POST
// GET on datan hakua, POST on datan syöttämistä
// GET ei muokkaa palvelimen dataa, POST muokkaa dataa
// GET selain voi jättää välimuistiin datan, POST ei mahdollista
// GET ei turvallinen, ei salaista tietoa, POST turvallinen

// Simuloidaan verkkosivun latausta, odottaa yhden sekunnin
sleep(1);

// normi muuttuja
$muuttja = "testi muuttuja";

// PHP:n globaali muuttuja
// $_GET $_FILES $_COOKIE
// echo $_SERVER["REQUEST_METHOD"]; // "POST" tai "GET" <- tämän perusteella joko jatketaan suoritusta tai annetaan virhe

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Jos vertailu on true

    // Tarkistetaan onko käyttäjänimi ja salasana oikein
    // 1. Otetaan tunnus ja salasana muuttujiin talteen
    $username = $_POST["username"];
    $password = $_POST["password"];

    if($username == "sasu"){
        if($password == "lol123"){
            // Tiedot oikein
            echo "Tervetuloa " . $username;
            // Lisätään koodi, jotta käyttäjä on "Kirjautunut sisään" ja tietoja ei tarvitse syöttää joka kerta
            $_SESSION["username"] = $username; // Käyttäjän sessiossa on "username" -avain, än on kirjautunut
            // $_SESSION["loggedin"] = true; // Toinen vaitoehto
            header("Location: memberArea.php"); // Siirto eteenpäin

        } else{
            // Väärä salasana, virhe ilmoitus ja siirto
            // Ei kannata ilmoittaa kumpi tieto oli väärin. Haitallinen käyttäjä saa vain vinkkejä tiedoista
            header("Location: index.php?error=login");
            echo "Väärä salasana";
        }
    }else {
        // Väärä tunnus, virhe ilmoitus ja siirto
        header("Location: index.php?error=login");
        echo "Väärä tunnus";
    }
}else{

    // Vertailu on false
    header("Location: index.php?test=123"); // Siirretään käyttäjä kirjautumissivulle
    echo "<h1>Invalid route</h1>"; // Virhe ilmoitus
    
}

?>
<!--Poistetaan TML koodi ja siirretään se omalle sivulle tämä tiedosto ainoastaan suorittaa 
käyttäjän kirjautumisen-->

 <!-- Kaksi eri tapaa kirjoittaa dataa PHP:lla -->
        <!-- $_POST/GET on taulukko, jossa on keys: value parametrejä. -->
        <p><?php echo "Username:  " . $_POST["username"]; ?></p>
        <?php echo "<p>Username:  " . $_POST["username"] . " </p>"; ?>
        <?php echo "<p>password " . $_POST["password"] . "</p"; ?>