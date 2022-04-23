<?php
    session_start();
    echo var_dump($_POST);
    include('bdconnect.php');

    $id = $_POST['id'];

    if (isset($_POST["accreditation"])) {

        $accreditation = $_POST['accreditation'];
    
        $modifier = "UPDATE \"infoPerso\" SET \"Accréditation\"='$accreditation' WHERE id='$id'";
        pg_query($bdd, $modifier);

    }

    if (isset($_POST["hierarchie"])) {

        $hierarchie = $_POST['hierarchie'];
    
        $modifier = "UPDATE \"infoPerso\" SET \"Hiérarchie\"='$hierarchie' WHERE id='$id'";
        pg_query($bdd, $modifier);

    }

    if (!isset($_POST["hierarchie"]) AND !isset($_POST["accreditation"])) {

        $modifier = "DELETE FROM \"infoPerso\" WHERE id='$id'";
        pg_query($bdd, $modifier);

        $modifier = "DELETE FROM \"identif\" WHERE id='$id'";
        pg_query($bdd, $modifier);

        $modifier = "DELETE FROM \"demandecong\" WHERE id='$id'";
        pg_query($bdd, $modifier);

    }

    $req = "SELECT \"Email\",\"Nom\" FROM public.\"infoPerso\" WHERE id = '$id'";

    $curseur = pg_query($bdd,$req);
    $row = pg_fetch_assoc($curseur);

    $mailDemandeur = $row["Email"];
    $nom = $row["Nom"];

    $notif = "Bonjour Monsieur/Madame $nom, 
            Votre Compte a été mis à jour par un responsable.
            Pour consulter votre nouvelle hiérarchie, veuillez vous connecter à votre espace personnel.
            En esperant être porteur de bonnes nouvelles.";

    //mail($mailDemandeur, "Votre hiérarchie", $notif);
    $_SESSION["reussi"] = 0;
    header("Location: ModifierCompte.php");

?>