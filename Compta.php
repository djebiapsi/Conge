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

    function randomColor() { 
        $str = '#'; 
        for($i = 0 ; $i < 6 ; $i++) { 
            $randNum = rand(0 , 15); 
            switch ($randNum) { 
                case 10: $randNum = 'A'; break; 
                case 11: $randNum = 'B'; break; 
                case 12: $randNum = 'C'; break; 
                case 13: $randNum = 'D'; break; 
                case 14: $randNum = 'E'; break; 
                case 15: $randNum = 'F'; break; 
            } 
            $str .= $randNum; 
        } 
        return $str; 
    } 



    $req = "SELECT * FROM \"demandecong\" INNER JOIN \"infoPerso\" ON \"infoPerso\".id = \"demandecong\".id WHERE \"statut\" = 'accepté'";
    
    $curseur = pg_query($bdd,$req);
    
    $i = 0;

    while ($row = pg_fetch_assoc($curseur)) {
        $dateDebut[$i] = $row["dateDébut"];
        $nom[$i] = $row["Nom"];
        $prenom[$i] = $row["Prenom"];
        $team[$i] = $row["Equipe"];
        $id[$i] = $row["id"];
        $hierarchieA[$i] = $row["Hiérarchie"];
        $idDemande[$i] = $row["idDemande"];
        $dateFin[$i] = $row["dateFin"];
        $duration[$i] = get_nb_open_days(strtotime($dateDebut[$i]), strtotime($dateFin[$i]));
        $color[$i] = randomColor();
        $i++;

    }
        
     // load template
     $template = $twig->load('Compta.html.twig');

     // set template variables
     // render template
     
    if (isset($dateDebut)) {
        echo $template->render(array(
        'nom' => $_SESSION["name"], 
        'prenom' => $_SESSION["fName"],
        'accreditation'=> $_SESSION["accréditation"],
        'hierarchie'=> $_SESSION["hierarchie"],
        'hierarchieA'=> $hierarchieA,
        'team'=> $team,
        'dateDebut'=> $dateDebut,
        'dateFin'=> $dateFin,
        'id'=> $id,
        'idDemande'=> $idDemande,
        'nomA'=> $nom,
        'prenomA'=> $prenom,
        'color'=> $color,
        'duration'=> $duration,

    ));
    }else{
        
        echo $template->render(array(
            'nom' => $_SESSION["name"], 
            'prenom' => $_SESSION["fName"],
            'accreditation'=> $_SESSION["accréditation"],
            'hierarchie'=> $_SESSION["hierarchie"],
        ));
    }
     
    
    
?>