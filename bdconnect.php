<?php

    //définir vos paramètres dec connexion

    // nom du serveur 
    $host="localhost";
    // nom utilisateur
    $login="postgres";
    // mot de passe
    $pass="bryanalex";
    // nom de la base de données
    $dbname="conge";


    // créer la connexion avec la base de données  dbname=$dbname user=$login password=$pass
    $bdd = pg_connect("host=$host port=5433 dbname=$dbname user=$login password=$pass");
    
    // Fonction permettant de compter le nombre de jours ouvrés entre deux dates
    function get_nb_open_days($date_start, $date_stop) {
        $arr_bank_holidays = array(); // Tableau des jours feriés
      
        // On boucle dans le cas où l'année de départ serait différente de l'année d'arrivée
        $diff_year = date('Y', $date_stop) - date('Y', $date_start);
        for ($i = 0; $i <= $diff_year; $i++) {
        $year = (int)date('Y', $date_start) + $i;
        // Liste des jours feriés
        $arr_bank_holidays[] = '1_1_'.$year; // Jour de l'an
        $arr_bank_holidays[] = '1_5_'.$year; // Fete du travail
        $arr_bank_holidays[] = '8_5_'.$year; // Victoire 1945
        $arr_bank_holidays[] = '14_7_'.$year; // Fete nationale
        $arr_bank_holidays[] = '15_8_'.$year; // Assomption
        $arr_bank_holidays[] = '1_11_'.$year; // Toussaint
        $arr_bank_holidays[] = '11_11_'.$year; // Armistice 1918
        $arr_bank_holidays[] = '25_12_'.$year; // Noel
      
        // Récupération de paques. Permet ensuite d'obtenir le jour de l'ascension et celui de la pentecote
        $easter = easter_date($year);
        $arr_bank_holidays[] = date('j_n_'.$year, $easter + 86400); // Paques
        $arr_bank_holidays[] = date('j_n_'.$year, $easter + (86400*39)); // Ascension
        $arr_bank_holidays[] = date('j_n_'.$year, $easter + (86400*50)); // Pentecote
        }
        //print_r($arr_bank_holidays);
        $nb_days_open = 0;
        while ($date_start < $date_stop) {
        // Si le jour suivant n'est ni un dimanche (0) ou un samedi (6), ni un jour férié, on incrémente les jours ouvrés
        if (!in_array(date('w', $date_start), array(0))
        && !in_array(date('j_n_'.date('Y', $date_start), $date_start), $arr_bank_holidays)) {
        $nb_days_open++;
         }
            $date_start += 86400;
         }
        return $nb_days_open;
    }
      


    // vérification de la connexion avec la BD
    if (!$bdd)
        {
            echo "Connexion non-reussie à pgsql ";
        } 
    else 
        {
           
        }
    
    
    // changer le jeu de caractères à utf8

?>