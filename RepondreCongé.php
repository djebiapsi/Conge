<?php

    session_start();
    include('bdconnect.php');

    if (isset($_SESSION["modifDemande"])) {

        echo "<div class=\"alert alert-icon alert-success\" role=\"alert\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
        <i class=\"fe fe-check mr-2\" aria-hidden=\"true\"></i> Modification enregistrée. 
      </div>";
        unset($_SESSION["modifDemande"]);
        
    }
    
    
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

    $accreditation = $_SESSION["accréditation"];

    if ($accreditation == 2) {
        
        $req = "SELECT * FROM \"demandecong\" INNER JOIN \"infoPerso\" ON \"infoPerso\".id = \"demandecong\".id";

        $curseur = pg_query($bdd,$req);

        $i = 0;

        while($row = pg_fetch_assoc($curseur)){


            if($row["statut"] == "soumis"){

                $idDemande[$i] = $row["idDemande"];
                $dateDebut[$i] = $row["dateDébut"];
                $dateFin[$i] = $row["dateFin"];
                $nom[$i] = $row["Nom"];
                $team[$i] = $row["Equipe"];
                $prenom[$i] = $row["Prenom"];
                $hierarchieAffich[$i] = $row["Hiérarchie"];
                
                $i++;
            }

        }
        

        // load template
        $template = $twig->load('RepondreConge.html.twig');

        // set template variables
        // render template
    
        if(isset($idDemande)){

            echo $template->render(array(
                'idDemande' => $idDemande, 
                'dateDebut' => $dateDebut,
                'dateFin'=> $dateFin,
                'nomAffich'=> $nom,
                'team'=> $team,
                'prenomAffich'=> $prenom,
                'hierarchieAffich'=> $hierarchieAffich,
                'nom' => $_SESSION["name"], 
                'prenom' => $_SESSION["fName"],
                'accreditation'=> $_SESSION["accréditation"],
                'hierarchie'=> $_SESSION["hierarchie"],
            ));

        }else {
            
            echo $template->render(array(
                'nom' => $_SESSION["name"], 
                'prenom' => $_SESSION["fName"],
                'accreditation'=> $_SESSION["accréditation"],
                'hierarchie'=> $_SESSION["hierarchie"],
            ));

        }
    }

?>