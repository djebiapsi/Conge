<?php
    session_start();
    
    if (isset($_SESSION["newMdp"])) {

      echo "<div class=\"alert alert-icon alert-success\" role=\"alert\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
      <i class=\"fe fe-check mr-2\" aria-hidden=\"true\"></i> Mot de pass mis à jour. 
    </div>";
      unset($_SESSION["newMdp"]);
      
    }elseif(isset($_SESSION["accesInterdit"])) {

      echo "<div class=\"alert alert-icon alert-danger\" role=\"alert\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
      <i class=\"fe fe-alert-triangle mr-2\" aria-hidden=\"true\"></i> Vous n'avez pas le droit d'être là. 
    </div>";
      unset($_SESSION["accesInterdit"]);

    }elseif(isset($_SESSION["compteInexistant"])) {

      echo "<div class=\"alert alert-icon alert-danger\" role=\"alert\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
      <i class=\"fe fe-alert-triangle mr-2\" aria-hidden=\"true\"></i> Mauvais pseudo et/ou mot de passe. 
    </div>";
      unset($_SESSION["compteInexistant"]);

    }elseif(isset($_SESSION["finSession"])) {

      echo "<div class=\"alert alert-icon alert-danger\" role=\"alert\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>
      <i class=\"fe fe-alert-triangle mr-2\" aria-hidden=\"true\"></i>Vous avez été déconnecté . 
    </div>";
      unset($_SESSION["finSession"]);

    }

  unset($_SESSION["pseudo"]);

  unset($_SESSION["password"]);


    //var_dump($_SESSION);
?>
<!doctype html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Connexion</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="./assets/js/require.min.js"></script>
    <script>
      requirejs.config({
          baseUrl: '.'
      });
    </script>
    <!-- Dashboard Core -->
    <link href="./assets/css/dashboard.css" rel="stylesheet" />
    <script src="./assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="./assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="./assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="./assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="./assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="./assets/plugins/input-mask/plugin.js"></script>
  </head>
  <body class="">
    <div class="page">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <img src="logo.jpg" class="h-6" alt="">
              </div>
              <form class="card" action="identif.php" method="post">
                <div class="card-body p-6">
                  <div class="card-title">Connexion à votre espace</div>
                  <div class="form-group">
                    <label class="form-label">Pseudo</label>
                    <input type="text" class="form-control" name="id" aria-describedby="emailHelp" placeholder="Pseudo">
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Mot De Passe
                    </label>
                    <input type="password" class="form-control" name="mdp" placeholder="Mot De Passe">
                  </div>
                  <div class="form-footer">
                    <input type="submit" value="Connexion" class="btn btn-primary btn-block">
                  </div>
                </div>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>