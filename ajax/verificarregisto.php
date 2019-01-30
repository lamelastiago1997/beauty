<?php
    /*
        1 --> existe
        0 --> não existe
    */

    include("../bd/conf.php");
    include("../bd/bd.php");

    $mydb = new bd();

    $val["existe"] = 0;

    try {
        $STH = $mydb->DBH->prepare("SELECT * FROM utilizadores WHERE u_email= ?");

        $STH->bindParam(1, $u_email);

        $u_email = $_POST["email"];

        $STH->execute();
        $STH->setFetchMode(PDO::FETCH_ASSOC);

        /* Signfica que encontrou um email */
        if($dados = $STH->fetch()) {
            $val["existe"] = 1;
        }

    } catch (Exception $e) {
        echo "Ups: " .$e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($val);
?>
