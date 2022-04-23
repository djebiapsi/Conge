<?php
    session_start();

    //echo var_dump($_POST);
    include('bdconnect.php');

    $idDemande = $_POST['idDemande'];
    $statut = $_POST['statut'];
    
    $modifier = "UPDATE \"demandecong\" SET \"statut\"='$statut' WHERE \"idDemande\"='$idDemande'";
    pg_query($bdd, $modifier);

    $req = "SELECT \"Email\",\"Nom\" FROM public.\"infoPerso\" INNER JOIN public.\"demandecong\" ON \"infoPerso\".id = \"demandecong\".id WHERE \"demandecong\".idDemande = '$idDemande'";

    $curseur = pg_query($bdd,$req);
    $row = pg_fetch_assoc($curseur);

    $mailDemandeur = $row["Email"];
    $nom = $row["Nom"];

    $notif = "Bonjour Monsieur/Madame $nom, 
            Vous avez reçu une réponse a votre demande de congé.
            Pour consulter votre réponse, veuillez vous connecter à votre espace personnel rubrique \"Voir Mes Demandes De Congé\".
            En esperant être porteur de bonnes nouvelles.";

    //mail($mailDemandeur, "Votre demande de congé", $notif);

    $_SESSION["modifDemande"] = 0;
    header("Location: RepondreCongé.php");

?>