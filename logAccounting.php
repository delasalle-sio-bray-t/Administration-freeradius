<?php
//SELECT * FROM `radacct` WHERE `acctstarttime`BETWEEN '2017/01/14 00:00:00' AND '2017/01/19 23:59:00' AND username = '001999b68918'
include("include/_inc_parametres.php");
include('include/connecter.php');
include("include/_inc_connexion.php");
session_start();
function convert_sec_time($time){

  $heures=intval($time / 3600);
  $minutes=intval(($time % 3600) / 60);
  $secondes=intval((($time % 3600) % 60));
  if ($heures <= 9){
    $heures = "0".$heures;
  }
  if ($minutes <= 9){
    $minutes = "0".$minutes;
  }
  if ($secondes <= 9){
    $secondes = "0".$secondes;
  }
  $rep = $heures."h".$minutes."min".$secondes."s";
  return $rep;
}
$poste = $_GET['poste'];
$date = $_GET['date'];
$date2 = $_GET['date2'];
//Récupération du formulaire
if ($poste != "" || $date != "" || $date2 != ""){
  //Cas ou on cherche a partir du nom de la machine
  if ($_GET['poste'] !="" && $_GET['date'] == "" && $_GET['date2']==""){
    $req_pre_log = $cnx->prepare("SELECT * FROM radacct WHERE username = '$poste' ORDER BY radacctid DESC");
  }
  //Cas ou on chercher a partir de la date
  if ($_GET['poste'] =="" && $_GET['date'] != "" && $_GET['date2']==""){
      $date = $date."%";
      $req_pre_log = $cnx->prepare("SELECT * FROM radacct WHERE acctstarttime LIKE '$date' ORDER BY radacctid DESC");
  }
  //Cas ou on chercher a partir de la date (2e champ)
  if ($_GET['poste'] =="" && $_GET['date'] == "" && $_GET['date2']!=""){
    $date2 = $date2."%";
    $req_pre_log = $cnx->prepare("SELECT * FROM radacct WHERE acctstarttime LIKE '$date2' ORDER BY radacctid DESC");
  }
  // Cas ou on cherche un poste a une date précise
  if ($_GET['poste'] !="" && $_GET['date'] !="" && $_GET['date2'] ==""){
    $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * FROM radacct WHERE acctstarttime LIKE '$date' AND username = '$poste' ORDER BY radacctid DESC");
  }
  // Cas ou on cherche un poste a une date précise (2e champ)
  if ($_GET['poste'] !="" && $_GET['date'] =="" && $_GET['date2'] !=""){
    $date2 = $date2."%";

    $req_pre_log = $cnx->prepare("SELECT * FROM radacct WHERE acctstarttime LIKE '$date2' AND username = '$poste' ORDER BY radacctid DESC");
  }
  //Cas ou on cherche entre 2 dates
  if ($_GET['poste'] =="" && $_GET['date'] !="" && $_GET['date2'] !=""){
      $date = $date." 00:00:00";
      $date2 = $date2." 23:59:59";
      $req_pre_log = $cnx->prepare("SELECT * FROM `radacct` WHERE `acctstarttime`BETWEEN '$date' AND '$date2' ORDER BY radacctid DESC");
  }
  //Cas ou on cherche un poste entre 2 date
  if ($_GET['poste'] !="" && $_GET['date'] !="" && $_GET['date2'] !=""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";

      $req_pre_log = $cnx->prepare("SELECT * FROM `radacct` WHERE `acctstarttime`BETWEEN
         '$date' AND '$date2' AND username = '$poste' ORDER BY radacctradacctid DESC");
  }

  $req_pre_log->execute();
  //le résultat est récupéré sous forme d'objet
  $ligne = $req_pre_log->fetch(PDO::FETCH_OBJ);
  if ($ligne == false){
    $msg =  "Pas de log pour cette recherche.";
  }

}

 ?>
<html>
   <head>
     <title>Administration</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="style.css" type="text/css">
      <link rel="stylesheet" href="styleTab.css" type="text/css">
      <link href="include/jquery/jquery-ui.css" rel="stylesheet">
      <script src="include/jquery/external/jquery/jquery.js"></script>
      <script src="include/jquery/jquery-ui.js"></script>
      <script>
      $( function() {
        $( "#date" ).datepicker();
        $( "#date2" ).datepicker();
      } );
      </script>
      <style>
      .tableau tr:last-child, .tableau td:last-child {
        border-left: none;}
      </style>
   </head>

   <body>
     <div  id="page">
            <a href="menu.php" class="bouton-menu">Accueil</a>
            <?php      if ($ligne == false){
                echo "<p>
                $msg
                </p>";
              }
   ?>
       <!-- Formulaire!-->
     <form enctype="multipart/form-data" action="logAccounting.php" method="get">
           <table class="tableau">
               <tr>
                 <th>Nom de l'équipement</th>
                 <th>Date</th>
                 <th>Si rempli, permet de voir les logs entre 2 dates</th>
               </tr>
              <tr>
                <td>
                  <select name="poste">
                    <option value="">Selectionner un poste</option>
                   <?php
                   $req_pre = $cnx->prepare("SELECT * FROM radcheck");
                   $req_pre->execute();
                   //le résultat est récupéré sous forme d'objet
                   $ligne2=$req_pre->fetch(PDO::FETCH_OBJ);

                   while ($ligne2) {
                     echo "<option value=".$ligne2->username.">".$ligne2->machine." (".$ligne2->username.")</option>";
                     $ligne2 = $req_pre->fetch(PDO::FETCH_OBJ);
                   }
                    ?>
                </select>
              </td>
                <td><input type="text" name="date" id="date" placeholder="Cliquer pour choisir une date"></td>
                <td><input type="text" name="date2" id="date2" placeholder="Cliquer pour choisir une date"></td>
              </tr>
              <tr><td></td><td><input type="submit" value="Rechercher"></td></tr>
           </table>
           </form>

           <div id="scrolltable">


                <table class="tableau1">
                  <thead>
                    <th>Nom de la machine</th>
                    <th>Port</th>
                    <th>Date de connexion</th>
                    <th>Date de déconnexion</th>
                    <th>Temps de connexion</th>
                  </thead>
                <tbody>
                  <?php
                  while ($ligne){
                    //Récupération de l'adresse mac de la machine
                    $mac = $ligne->username;
                    //On recupere le nom de la machine en fonction de son adresse mac
                    $req_pre2 = $cnx->prepare("SELECT machine FROM radcheck WHERE username = '$mac' ");
                    $req_pre2->execute();
                    //le résultat est récupéré sous forme d'objet
                    $nomMachine =$req_pre2->fetchColumn(0);
                    ?>
                  <tr>
                    <td><?php echo utf8_encode($nomMachine); ?></td>
                    <td><?php echo utf8_decode($ligne->nasportid) - 50000; ?></td>
                    <td><?php echo utf8_decode($ligne->acctstarttime); ?></td>
                    <td><?php
                          if ($ligne->acctstoptime !=""){
                            echo utf8_decode($ligne->acctstoptime);
                          }
                          else {
                            echo "Poste branché";
                          }


                    ?></td>
                    <td><?php echo convert_sec_time($ligne->acctsessiontime);?></td>


                  </tr>
                  <?php
                  $ligne=$req_pre_log->fetch(PDO::FETCH_OBJ);
                }
                 ?>
                </tbody>
                </table>

         </body>
       </html>
