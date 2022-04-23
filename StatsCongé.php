<?php
    session_start();
    include('bdconnect.php');
    
    //TWIG

    include 'vendor/autoload.php';
                        
    try {
        // le dossier ou on trouve les templates
        $loader = new Twig\Loader\FilesystemLoader('templates');

        // initialiser l'environement Twig
        $twig = new Twig\Environment($loader , [
            'debug' => true
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

    } catch (Exception $e) {

        die ('ERROR: ' . $e->getMessage());

    }
  
    //Variable pour le template
  
    $idDemande = $_POST["idDemande"];
    $dateDebut = $_POST["dateDebut"];
    $dateFin = $_POST["dateFin"];


    
    $req = "select id from \"demandecong\" where \"idDemande\" = '$idDemande'";
    $curseur = pg_query($bdd,$req);
    $row = pg_fetch_assoc($curseur);
    $idDemandeur = $row["id"];

    $duration = 0;
    $req = "select \"dateFin\", \"dateDébut\" from \"demandecong\" where \"statut\" = 'accepté' and id = '$idDemandeur'";
    $curseur = pg_query($bdd,$req);
    while($row = pg_fetch_assoc($curseur)){
        $duration += get_nb_open_days(strtotime($row["dateDébut"]), strtotime($row["dateFin"]));
    }


    $req = "SELECT count(distinct id) FROM \"demandecong\" WHERE \"statut\" = 'accepté' and id != '$idDemandeur' and ((\"dateDébut\" < '$dateDebut' AND \"dateFin\" > '$dateFin') OR (\"dateDébut\" between '$dateDebut' and '$dateFin') or (\"dateFin\" between '$dateDebut' and '$dateFin'))";
    $curseur = pg_query($bdd,$req);
    $row = pg_fetch_assoc($curseur);
    $autreDepart = $row["count"];
    
    $req = "SELECT count(*) FROM \"infoPerso\" ";
    $curseur = pg_query($bdd,$req);
    $row = pg_fetch_assoc($curseur);
    $effectif = $row["count"];

    $req = "SELECT * FROM \"demandecong\" INNER JOIN \"infoPerso\" ON \"infoPerso\".id = \"demandecong\".id  WHERE \"statut\" = 'accepté' and \"infoPerso\".id != '$idDemandeur' and ((\"dateDébut\" < '$dateDebut' AND \"dateFin\" > '$dateFin') OR (\"dateDébut\" between '$dateDebut' and '$dateFin') or (\"dateFin\" between '$dateDebut' and '$dateFin'))";
 
    $curseur = pg_query($bdd,$req);

    $i = 0;

    while($row = pg_fetch_assoc($curseur)){

            $idDemandeA[$i] = $row["idDemande"];
            $dateDebutA[$i] = $row["dateDébut"];
            $dateFinA[$i] = $row["dateFin"];
            $nom[$i] = $row["Nom"];
            $team[$i] = $row["Equipe"];
            $prenom[$i] = $row["Prenom"];
            $hierarchieAffich[$i] = $row["Hiérarchie"];
            
            $i++;
    }

     // load template
     $template = $twig->load('StatsCongé.html.twig');

     // set template variables
     // render template
    
 
     
    if(isset($_POST["idDemande"])){
        if(!isset($idDemandeA)){

            echo $template->render(array(
                'nom' => $_SESSION["name"], 
                'prenom' => $_SESSION["fName"],
                'accreditation'=> $_SESSION["accréditation"],
                'hierarchie'=> $_SESSION["hierarchie"],
                'idDemande'=>$_POST["idDemande"],
                'duration'=>$duration,
                'autreDepart'=>$autreDepart,
                'effectif'=>$effectif,
                'idDemandeA' => array(),
            ));

        }else{

            echo $template->render(array(
                'nom' => $_SESSION["name"], 
                'prenom' => $_SESSION["fName"],
                'accreditation'=> $_SESSION["accréditation"],
                'hierarchie'=> $_SESSION["hierarchie"],
                'idDemande'=>$_POST["idDemande"],
                'duration'=>$duration,
                'autreDepart'=>$autreDepart,
                'effectif'=>$effectif,
                'idDemandeA' => $idDemandeA, 
                'dateDebut' => $dateDebutA,
                'dateFin'=> $dateFinA,
                'team'=> $team,
                'nomAffich'=> $nom,
                'prenomAffich'=> $prenom,
                'hierarchieAffich'=> $hierarchieAffich,
            ));

        }
    }
?>
