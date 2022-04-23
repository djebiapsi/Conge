<?php
    session_start();
    include ("bdconnect.php");

    if(isset($_POST["start"])&&isset($_POST["end"])){
        $debut = $_POST["start"];
        $fin = $_POST["end"];
        $nom = $_SESSION['name'];
        $prenom = $_SESSION['fName'];




        if($fin < $debut){
            $_SESSION["dateAnterieur"] = 0;
            header("Location: SoumettreCongée.php");
        }else{
            

            echo "<p class = 'title'>Demande enregistrée</p>";
            echo "<a href='identif.php'>Retour...</a>";

            $id = $_SESSION["id"];

            $req = "select max(\"idDemande\") from \"demandecong\"";

                $curseur = pg_query($bdd,$req);
                $row = pg_fetch_assoc($curseur);

                if(isset($row)){

                    $idDemande = $row["max"]+1;

                }else{

                    $idDemande = 1;

                }

            $ajouter = "insert into \"demandecong\" (\"idDemande\",id,\"dateDébut\",\"dateFin\",\"statut\") values ('$idDemande','$id','$debut','$fin','soumis')";
            pg_query($bdd, $ajouter);
            
            
            $notif = "Bonjour, 
            Monsieur $nom à soumis une nouvelle demande de congé.
            Merci de vous connectez sur la plateforme pour répondre à la demande.";

            $req = "SELECT \"Email\" FROM public.\"infoPerso\" WHERE \"Accréditation\" = '2'";

            $curseur = pg_query($bdd,$req);

            while($row = pg_fetch_assoc($curseur)){

                $mailRes = $row["Email"];

               mail($mailRes, "Demande de congé", $notif);

            
            }
            $_SESSION["dateEnregistre"] = 0;
            header("Location: SoumettreCongée.php");
        }
    }
    

?>
