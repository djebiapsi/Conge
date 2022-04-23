<?php
    session_start();
    $id = $_SESSION["id"];

    include("bdconnect.php");
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
    
    $req = "SELECT \"dateDébut\", \"dateFin\", \"statut\" FROM public.\"demandecong\"  WHERE id = '$id'";



        $curseur = pg_query($bdd,$req);

        $co = 0;
        while($row = pg_fetch_assoc($curseur)){

            $dateDébut[$co] = $row["dateDébut"];
            $dateFin[$co] = $row["dateFin"];

            $statut[$co] = $row["statut"];

            if($statut[$co] == "rejeté"){
                $color[$co] = "#DC143C";
            }elseif ($statut[$co] == "accepté") {
                $color[$co] = "#8A2BE2";
            }elseif ($statut[$co] == "soumis") {
                $color[$co] = "#696969";
            }

            $duration[$co] = get_nb_open_days(strtotime($dateDébut[$co]), strtotime($dateFin[$co]));
            
            $co++;
        }


    // load template
    $template = $twig->load('VoireCongée.html.twig');

    // set template variables
    // render template
    

    if (isset($dateDébut)) {
        echo $template->render(array(
            'nom' => $_SESSION["name"], 
            'prenom' => $_SESSION["fName"],
            'accreditation'=> $_SESSION["accréditation"],
            'hierarchie'=> $_SESSION["hierarchie"],
            'dateDebut' => $dateDébut, 
            'dateFin' => $dateFin,
            'statut' => $statut,
            'color' => $color,
            'duration' => $duration,

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

 
