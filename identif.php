<?php
    session_start();
    // var_dump($_SESSION);

    

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
   
    include("bdconnect.php");

    if(isset($_POST["id"])&&isset($_POST["mdp"])){
        $pseudo = $_POST["id"];
        $password = $_POST["mdp"];
    }elseif(isset($_SESSION["password"])&&isset($_SESSION["pseudo"])){
        $pseudo = $_SESSION["pseudo"];
        $password = $_SESSION["password"];
    }

    if(!isset($pseudo) && !isset($password)){

        $_SESSION["finSession"] = 0;
        header('Location: index.php');
        
    }else{

        if(connexionUtilisateur($pseudo, $password, $bdd)){//Verifie si un compte existe

            $req = "SELECT * FROM public.\"infoPerso\" INNER JOIN \"identif\" ON \"infoPerso\".id = identif.id WHERE identif.pseudo = '$pseudo'";

            $curseur = pg_query($bdd,$req);
            $row = pg_fetch_assoc($curseur);

            $_SESSION["name"] = $row["Nom"];
            $_SESSION["fName"] = $row["Prenom"];
            $_SESSION["email"] = $row["Email"];
            $_SESSION["accréditation"] = $row["Accréditation"];
            $_SESSION["pseudo"] = $row["pseudo"];
            $_SESSION["password"] = $password;
            $_SESSION["hierarchie"] = $row["Hiérarchie"];

            $req = "SELECT id FROM public.\"infoPerso\" WHERE \"Nom\" = '".$_SESSION["name"]."' AND \"Prenom\" = '".$_SESSION["fName"]."'";

            $curseur = pg_query($bdd,$req);
            $row = pg_fetch_assoc($curseur);


            $_SESSION["id"] = $row["id"];
            
            $id = $row["id"];

            $req = "select \"dateDébut\", \"dateFin\" from \"demandecong\" where id = '$id' and statut = 'accepté'";
            $curseur = pg_query($bdd,$req);

            $i = 0;

            while($row = pg_fetch_assoc($curseur)){

                $start[$i] = strtotime($row["dateDébut"]);
                $end[$i] = strtotime($row["dateFin"]);
                $i++;

            }
            if (isset($start)) {

                for ($i=0; $i < sizeof($start); $i++) { 
                    $duration[$i] = get_nb_open_days($start[$i], $end[$i]);
                    $totalDay = array_sum($duration);
                }

            }else {
                $totalDay = 0;
            }

            
            
            

            $req = "select COUNT(*) from \"demandecong\" where id = '$id'";
            $curseur = pg_query($bdd,$req);
            $row = pg_fetch_assoc($curseur);

            $nbrDemande = $row["count"];

            $req = "select COUNT(*) from \"demandecong\" where statut = 'accepté' and id ='$id'";
            $curseur = pg_query($bdd,$req);
            $row = pg_fetch_assoc($curseur);

            $nbrAccepte = $row["count"];

            $req = "select COUNT(*) from \"demandecong\" where statut = 'soumis' and id ='$id'";
            $curseur = pg_query($bdd,$req);
            $row = pg_fetch_assoc($curseur);

            $nbrSoumis = $row["count"];

            $req = "select COUNT(*) from \"demandecong\" where statut = 'rejeté' and id ='$id'";
            $curseur = pg_query($bdd,$req);
            $row = pg_fetch_assoc($curseur);

            $nbrRejete = $row["count"];



        
        }else{

            //var_dump($_SESSION);
            $_SESSION["compteInexistant"] = 0;
            header('Location: index.php');
            

        }
    }
    function connexionUtilisateur($pse, $mdp, $bd){

        $bool = false;

        $count = "SELECT password FROM \"identif\" WHERE pseudo = '$pse'";

        $curseur = pg_query($bd,$count);

        while($row = pg_fetch_assoc($curseur)){

            if(isset($row["password"])){

                $bool = password_verify($mdp, $row["password"]);

                //var_dump($row["password"]);
            
            }

        }

        return $bool;

    }

    
    //Variable pour le template

    
    
     // load template
     $template = $twig->load('identif.html.twig');

     // set template variables
     // render template
     
 
     
    echo $template->render(array(
        'nom' => $_SESSION["name"], 
        'prenom' => $_SESSION["fName"],
        'accreditation'=> $_SESSION["accréditation"],
        'hierarchie'=> $_SESSION["hierarchie"],
        'nbrDemande'=>$nbrDemande,
        'nbrAccepte'=>$nbrAccepte,  
        'nbrRejete'=>$nbrRejete, 
        'nbrSoumis'=>$nbrSoumis,
        'totalDay'=>$totalDay,
        
    ));
    
 
       

?>
