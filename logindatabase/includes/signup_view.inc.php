<?php
// Generoi käyttöliittymään sisältöä

declare(strict_types= 1);

function check_signup_errors() {
    if (isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];

        echo "<br>";

        foreach($errors as $error) {
            echo "<p class='form-error'>" . $error . "</p>";
        }

        // Kun session data on käsitelty, poistetaan lopuksi
        unset($_SESSION["errors_signup"]);
    }
    elseif (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo "<p class='form-success'>Signup success!" . "</p>";
    }
}

function signup_inputs() {
    if (isset($_SESSION["signup_data"]["username"]) && 
        isset($_SESSION["errors_signup"]["username_taken"]) === false) {
            echo '<input type="text" name="username" placeholder="Username">
            value="'.htmlspecialchars($_SESSION["signup_data"]["username"]).'"';
    } else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    echo '<input type="password" name="password" placeholder="Password">';

    if (isset($_SESSION["signup_data"]["email"]) && 
        isset($_SESSION["errors_signup"]["email_used"]) === false &&
        isset($_SESSION["errors_singup"]["invalid_email"]) === false) {
            echo '<input type="text" name="email" placeholder="E-mail">
            value="'. htmlspecialchars($_SESSION["signup_data"]["email"]).'"';
        } else {
            echo '<input type="text" name="email" placeholder="E-mail">';
        }

        unset($_SESSION["signup_data"]);
}
