<?php

// Tässä tiedostossa vastaan otetaan kuva tiedosto ja tallennetaab se palvelimelle

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK ){

        // Tiedosto on saapunut onnistuneesti, suoritetaan tallennus

        // 1. Tarkistetaan, että kohde kansio on olemassa
        // Kansio kannattaa luoda palvelimelle valmiiksi ja siihen oikeat asetukset
        // (turvallisuus)
        $targetDir = "uploads/";
        if(!file_exists($targetDir)){
            die("Folder not setup on the server!");
            // PHP voisi luoda kansio koodilla, mutta sen asetukset on
            // käyttöjärjestelmä kohtaisia
        }

        $product_id = 1; // Haetaan tietokannasta
        // 2. Korvataan käyttäjän syöttämä tiedoston nimi
        $customFileName = $product_id; // Lisätä jonkin käyttäjän määrittämä nimi

        // 3. tARKISTETAAN TIEDOSTON TIEDOSTOPÄÄTE

        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        $allowedExtensions = ["jpg", "png"];

        // Jos tiedostonpääte ei ole sallitut listalla

        if(!in_array($imageFileType, $allowedExtensions)){
            die("Error: Not allowed filetype!");
        }

        // 4. PHP.ini asetukset ja siellä max_size ja max_files

        // Tässä voi myös tarkistaa
        // Määritetään maksimi tiedoston koko tavuina (8 bit)
        // Tässä määritellään 50 MB
        $maxFileSize = 50 * 1024 * 1024; // 50 * bytes in kilo * kilo in mega

        if($_FILES["image"]["size"] > $maxFileSize){
            die("Error: File exceeds the maximum size!");
        }

        // 5. Yhdistetään tiedoston nimen eri osat
        //              kansio      tiedostonnimi    piste   tiedostonpääte
        $targetFile = $targetDir . $customFileName . "." . $imageFileType;


        // 6. Siirretään tiedosto uploads kansioon
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
            echo "Image uploaded successfully!";
        } else {
            echo "Upload failed!";
        }

    }
    else {
        echo "Error: " . $_FILES["image"]["error"];
    }
}

?>