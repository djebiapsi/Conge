<?php
    session_start();
    include('bdconnect.php');

    //if($_SESSION["accréditation"] == 2){

        if (isset($_POST["nom"])) {

            $pseudo = $_POST["pseudo"];
            $mdp = $_POST["mdp"];
            $mdp2 = $_POST["mdp2"];
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $hierarchie = $_POST["hierarchie"];
            $team = $_POST["team"];


            if($mdp == $mdp2){

                $req = "select password FROM identif WHERE \"pseudo\" = '$pseudo'";

                $curseur = pg_query($bdd,$req);

                $boolPass = true;

                while($row = pg_fetch_assoc($curseur)){

                    if(password_verify($mdp, $row["password"])){
                        $boolPass = false;
                    }

                }
                
                //var_dump($boolPass);
                if($boolPass) {

                    $req = "select max(id) from identif";

                    $curseur = pg_query($bdd,$req);
                    $row = pg_fetch_assoc($curseur);

                    if(isset($row)){

                        $id = $row["max"]+1;

                    }else{

                        $id = 1;

                    }

                    $mdp = password_hash($mdp, PASSWORD_DEFAULT);

                    $ajouter = "insert into identif (pseudo,password,id) values ('$pseudo','$mdp',$id)";
                    pg_query($bdd, $ajouter);

                    $req = "SELECT id FROM identif WHERE pseudo = '$pseudo'";

                    $curseur = pg_query($bdd,$req);
                    $row = pg_fetch_assoc($curseur);

                    $id = $row["id"];

                    if ($hierarchie == "Collaborateur") {
                        $accréditation = 1;
                    }else{
                        $accréditation = 2;
                    }

                    $ajouter = "insert into public.\"infoPerso\" (\"Nom\",\"Prenom\",\"Email\",\"Hiérarchie\",\"Accréditation\",\"Equipe\",id) values ('$nom','$prenom','$email','$hierarchie','$accréditation', '$team', '$id')";
                    pg_query($bdd, $ajouter);

                    $_SESSION["compteCree"] = 0;
                    header('Location: CreerCompte.php');

                
                }else{

                    $_SESSION["compteExistant"] = 0;
                    header('Location: CreerCompte.php');
            
                }

            }else {
                $_SESSION["mdpS"] = 0;
                //var_dump($_POST);
                header('Location: CreerCompte.php');
            }
        }

    //}else{

    //    $_SESSION["accesInterdit"] = 0;
    //    header('Location: index.php');

    //}
?>
