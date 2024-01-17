<?php

// Tämä tiedosto käy läåi sähköposton lähetyksen
// Sähköpostin lähetys tapahtuu SMTP:n kautta (paikallinen tai verkossa)
// Jotta gmail toimii, tarvitaan PHPMailer kirjasto projektissa
// Tässä esimerkissä puuttuu PHPMailer käyttö

// PHP.ini voi määrittää myös oletukset

// ini_set muokkaa tämä suorituksen aikaisen asetuksen
ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port", "587"); // Arvot löytyvät googlen sivuilta

// Gmail asetukset
ini_set("smtp_auth", "true"); // TLS -> Transport Layer Security -> encryption
ini_set("smtp_username", "osoite@gmail.com");
ini_set("smtp_password", "gmail_salasana");

$to = "joku.sp@gmail.com"; // Jostakin haetaan osoite, esim tietokanta
$subject = "Password recovery";
$message ="Here us your link to recover password.

            Click here if you did not request this.                
            ";
            // Välttämättä ei ymmärrä tyhjiä välejä ja rivinvaihtoa
$headers ="From: do-not-reply@service.test";

// mail() palauttaa true tai false, onnistuiko lähetys
$operaationLopputulos = mail($to, $subject, $message, $headers);
// mail() funktio delegoi sähköpostin lähettämisen jollekin SMTP-palvelimelle
// (Simple Mail Transfer Protocol)
// Aikoinaan PHP on voinut lähettää sähköpostia

if($operaationLopputulos) {
    // true
    echo "Email sent!";
} else {
    // false
    echo "Failed to send mail!";
    // Jotakin muuta logiikkaa
}

// Sennetaan PHPMailer
// Lähetetään tieto SMTP palvelimelle käyttämällä tätä kirjastoa
$mail = new PHPMailer();

?>