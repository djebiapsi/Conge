<?php

    session_start();
    include('bdconnect.php');

    if (isset($_SESSION["reussi"])) {

        echo "<div class=\"alert alert-icon alert-success\" role=\"alert\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
        <i class=\"fe fe-check mr-2\" aria-hidden=\"true\"></i> Modification enregistrée. 
      </div>";
        unset($_SESSION["reussi"]);
        
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
        
        $req = "SELECT * FROM \"infoPerso\"";

        $curseur = pg_query($bdd,$req);

        $i = 0;

        while($row = pg_fetch_assoc($curseur)){

                $accreditationAffich[$i] = $row["Accréditation"];
                $idAffich[$i] = $row["id"];
                $nom[$i] = $row["Nom"];
                $prenom[$i] = $row["Prenom"];
                $hierarchie[$i] = $row["Hiérarchie"];
                $team[$i] = $row["Equipe"];
                
                $i++;
           
        }

        
        // load template
        $template = $twig->load('ModifCompte.html.twig');

        // set template variables
        // render template
        
    
        if(isset($prenom)){

            echo $template->render(array(
                'accreditationAffich' => $accreditationAffich, 
                'idAffich' => $idAffich,
                'nomAffich'=> $nom,
                'team'=> $team,
                'prenomAffich'=> $prenom,
                'hierarchieAffich'=> $hierarchie,
                'nom' => $_SESSION["name"], 
                'prenom' => $_SESSION["fName"],
                'accreditation'=> $_SESSION["accréditation"],
                'hierarchie'=> $_SESSION["hierarchie"],
            ));

        }else {
            
            echo $template->render(array(
                
            ));

        }
    }

?>