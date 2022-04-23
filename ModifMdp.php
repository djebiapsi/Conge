<?php

    session_start();
    include('bdconnect.php');

    if(isset($_POST["newMdp2"])){

        if ($_POST["newMdp1"] == $_POST["newMdp2"]) {

            $id = $_SESSION["id"];
            
            $req = "select \"password\" from \"identif\" where id='$id'";
            $curseur = pg_query($bdd,$req);
            $row = pg_fetch_assoc($curseur);

            if (password_verify($_POST["lastMdp"], $row["password"])) {

                $newPassword = password_hash($_POST["newMdp1"], PASSWORD_DEFAULT);

                $ajouter = "UPDATE \"identif\" SET \"password\"='$newPassword' WHERE id='$id'";
                pg_query($bdd, $ajouter);

                $_SESSION["newMdp"] = 0;
                
                header("Location: index.php");

            }else {

                $_SESSION["badMdp"] = 0;
                header("Location: changerMdp.php");
                
            }
            
        }else {

            $_SESSION["mdpS"] = 0;
            header("Location: changerMdp.php");

        }
    }

?>