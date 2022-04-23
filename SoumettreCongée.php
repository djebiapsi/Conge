<?php
    session_start();

    if (isset($_SESSION["dateEnregistre"])) {

        echo "<div class=\"alert alert-icon alert-success\" role=\"alert\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
        <i class=\"fe fe-check mr-2\" aria-hidden=\"true\"></i> Demande enregistrée. 
      </div>";
        unset($_SESSION["dateEnregistre"]);
        
      }elseif(isset($_SESSION["dateAnterieur"])) {
  
        echo "<div class=\"alert alert-icon alert-danger\" role=\"alert\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
        <i class=\"fe fe-alert-triangle mr-2\" aria-hidden=\"true\"></i> Date de fin antérieur à la date de début. 
      </div>";
        unset($_SESSION["dateAnterieur"]);
  
      }

    $date = date("Y-m-d");
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
    
        
        
         // load template
         $template = $twig->load('SoumettreCongé.html.twig');
    
         // set template variables
         // render template
         
     
         
        echo $template->render(array(
            'nom' => $_SESSION["name"], 
            'prenom' => $_SESSION["fName"],
            'accreditation'=> $_SESSION["accréditation"],
            'hierarchie'=> $_SESSION["hierarchie"],
            'dateDuJour' => $date
        ));
        
?>
