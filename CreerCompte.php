<?php
    session_start();

    if (isset($_SESSION["compteCree"])) {
        echo "<div class=\"alert alert-icon alert-success\" role=\"alert\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
        <i class=\"fe fe-check mr-2\" aria-hidden=\"true\"></i> Compte créé. 
      </div>";
        unset($_SESSION["compteCree"]);
    }elseif (isset($_SESSION["compteExistant"])) {
        echo "<div class=\"alert alert-icon alert-danger\" role=\"alert\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
        <i class=\"fe fe-alert-triangle mr-2\" aria-hidden=\"true\"></i>Identifiants déja existant. 
      </div>";
        unset($_SESSION["compteExistant"]);
    }elseif (isset($_SESSION["mdpS"])) {
        echo "<div class=\"alert alert-icon alert-danger\" role=\"alert\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
        <i class=\"fe fe-alert-triangle mr-2\" aria-hidden=\"true\"></i>Les deux mots de passe sont singuliers. 
      </div>";
        unset($_SESSION["mdpS"]);
    }


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
     $template = $twig->load('CreerCompte.html.twig');

     // set template variables
     // render template
     
 
     
    echo $template->render(array(
        'nom' => $_SESSION["name"], 
        'prenom' => $_SESSION["fName"],
        'accreditation'=> $_SESSION["accréditation"],
        'hierarchie'=> $_SESSION["hierarchie"],
    ));
?>