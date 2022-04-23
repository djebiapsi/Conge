<?php
    session_start();
    include("bdconnect.php")

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
     $template = $twig->load('StatsEmployé.html.twig');

     // set template variables
     // render template
     
 
     
    echo $template->render(array(
        'nom' => $_SESSION["name"], 
        'prenom' => $_SESSION["fName"],
        'accreditation'=> $_SESSION["accréditation"],
        'hierarchie'=> $_SESSION["hierarchie"],
    ));
    
?>