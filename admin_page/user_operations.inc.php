<?php

// Tässä tiedostossa on käyttäjän SQL kysely
// 1. delete_user

function delete_user($pdo, $id){
    try{
        // UPDATE, päivitetään taulun riviä
        $stmt = $pdo->prepare("UPDATE users SET deleted_at = :deleted_time WHERE UserID = :user_id");
        //                              taulu           sarake                      mikä rivi               
        
        $deletedTime = date("Y-m-d H:i:s");
        // Asetetaan parametrin :deleted_time ja user_id
        $stmt->bindParam("deleted_time", $deletedTime, PDO::PARAM_STR);
        $stmt->bindParam("user_id", $id, PDO::PARAM_INT);

        $stmt->execute();
        
        return "User deleted successfully!";
    }
    catch(PDOExeception){
        return "error: $e";
    }
} // delete_user

function restore_user($pdo, $id){
    try{
        // UPDATE, päivitetään taulun riviä
        $stmt = $pdo->prepare("UPDATE users SET deleted_at = :deleted_time WHERE UserID = :user_id");
        //                              taulu           sarake                      mikä rivi               
        
        $deletedTime = null;
        // Asetetaan parametrin :deleted_time ja user_id
        $stmt->bindParam("deleted_time", $deletedTime, PDO::PARAM_STR);
        $stmt->bindParam("user_id", $id, PDO::PARAM_INT);

        $stmt->execute();
        
        return "User restored successfully!";
    }
    catch(PDOExeception){
        return "error: $e";
    }
} // restore_user

function getUserDetails($pdo, $userid) {
    try{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = :user_id");
    $stmt->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $stmt->execute();
    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    return $userDetails;
    }
    catch(PDOExeception $e) {
        return "error: $e";
    }

} // getUserDetails