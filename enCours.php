<?php
$page = $_SERVER['REQUEST_URI'] ;
$sec = "30";
header("Refresh: $sec; url=$page");
?>
<?php
include('include/connecter.php');
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
session_start();
if(isset($_GET['req'])){
  $req = $_GET['req'];
  if ($req == "co"){
    $req_pre = $cnx->prepare("SELECT radacctid, username, nasportid, acctstarttime, acctstoptime, acctsessiontime from radacct WHERE acctstoptime IS NULL ORDER BY radacctid DESC LIMIT 50");

  }
  if($req == "deco"){
    $req_pre = $cnx->prepare("SELECT radacctid, username, nasportid, acctstarttime, acctstoptime, acctsessiontime from radacct WHERE acctstoptime != '' ORDER BY radacctid DESC LIMIT 50");
  }
}
else{
  $req_pre = $cnx->prepare("SELECT radacctid, username, nasportid, acctstarttime, acctstoptime, acctsessiontime from radacct ORDER BY radacctid DESC LIMIT 50");
}


$req_pre->execute();
//le résultat est récupéré sous forme d'objet
$ligne=$req_pre->fetch(PDO::FETCH_OBJ);
  $mac = $ligne->username;

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

function dif_date($d2){
  $tmp = time();
  //$d1 = date('d/m/Y H:i:s', $tmp);
  $d1 = new DateTime();
  $d1->setTimestamp($tmp);
  //$d2 = new DateTime('2017-01-19 14:43:50');
  $diff = $d1->diff($d2);
  $diffa = $d1->diff($d2);
  $diffm = $d1->diff($d2);
  $diffh = $d1->diff($d2);
  $diffi= $d1->diff($d2);
  $diffs = $d1->diff($d2);

  $rep = "";

  $rep = $rep.$nb_heur = $diffh->h." H ";
  $rep = $rep.$nb_min = $diffi->i." min ";
  $rep = $rep.$nb_sec = $diffs->s." s ";
  return $rep;
}

 ?>
<html>

   <head>
      <title>Logs</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="style.css" type="text/css">
      <style>
            div#log {
              text-align: center;
              width: 850px;
              height: : 800px;
              margin: 0px auto;
              padding: 0;
              border: #000 1px solid;

              -moz-border-radius: 15px;
              -webkit-border-radius: 15px;
              -o-border-radius: 15px;
              -ms-border-radius: 15px;
              -khtml-border-radius: 15px;
              border-radius: 15px;
              background: -moz-linear-gradient(top, rgb(255, 255, 255), rgb(210, 210, 210));
              background: -webkit-gradient(linear, left top, left bottom, from(rgb(255, 255, 255)), to(rgb(210, 210, 210)));
              background: linear-gradient(to bottom, rgb(255, 255, 255), rgb(225, 225, 225));
            }
            .tableau1 {
          width: 780px;
          table-layout: fixed;
          border-collapse: collapse;
            }
            .tableau1 th {
              text-decoration: underline;
            }
            .tableau1 th,
            .tableau1 td {
              padding: 5px;
              text-align: left;
            }
            <?php
            if ($_GET['req'] == co){
            echo"  .tableau1 td:nth-child(1),
              .tableau1 th:nth-child(1) {
                width: 195px;
              }
              .tableau1 td:nth-child(2),
              .tableau1 th:nth-child(2) {
                width: 195px;
              }
              .tableau1 td:nth-child(3),
              .tableau1 th:nth-child(3) {
                width: 195px;

              }
              .tableau1 td:nth-child(4),
              .tableau1 th:nth-child(4) {
                width: 195px;
              }
              .tableau1 td:first-child, .tableau1 th:first-child {
                border-left: none;
                width: 195px;}";
              }
              else{
                echo "
                .tableau1 td:first-child, .tableau1 th:first-child {
                  border-left: none;
                  width: 150;}

                .tableau1 td:nth-child(1),
                .tableau1 th:nth-child(1) {
                  min-width: 150px;
                }
                .tableau1 td:nth-child(2),
                .tableau1 th:nth-child(2) {
                  min-width: 50px;
                }
                .tableau1 td:nth-child(3),
                .tableau1 th:nth-child(3) {
                  min-width: 175px;

                }
                .tableau1 td:nth-child(4),
                .tableau1 th:nth-child(4) {
                  min-width: 175px;
                }
                .tableau1 td:nth-child(5),
                .tableau1 th:nth-child(5) {
                      min-width: 173px;
                }";

              }

            ?>




            .tableau1 thead tr {
              display: block;
              position: relative;
            }
            .tableau1 tbody {
              display: block;
              overflow: auto;
              width: 100%;
              height: 300px;
            }
            .tableau1 tbody tr:nth-child(even) {
              background-color: #DDD;
            }
            .old_ie_wrapper {
              height: 300px;
              width: 750px;
              overflow-x: hidden;
              overflow-y: auto;
            }
            .old_ie_wrapper tbody {
              height: auto;
            }
      </style>

   </head>
   <body>
 <div id="log">
   <a href="menu.php" class="bouton-menu">Accueil</a>

<div id="scrolltable">


     <table class="tableau1">
       <thead>
         <th>Nom de la machine</th>
         <th>Port</th>
         <th>Date de connexion</th>
         <?php
         if ($_GET['req'] == "deco"){
           echo '<th>Date de déconnexion</th>';
           echo '<th>Temps de connexion</th>';
         }
         if ($_GET['req'] == "co"){
           echo '<th>Temps de connexion</th>';
         }
          ?>


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
    <?php
    if ($_GET['req'] == "deco"){
      echo "<td>".utf8_decode($ligne->acctstoptime)."</td>";
      echo "<td>".convert_sec_time($ligne->acctsessiontime)."</td>";
    }
    if ($_GET['req'] == "co"){
      $now = time();
      $date = new DateTime(trim($ligne->acctstarttime));
      $temps = dif_date($date);
    echo '<td>'.$temps.'</td>';

    }
     ?>


  </tr>
  <?php
  $ligne=$req_pre->fetch(PDO::FETCH_OBJ);
}
 ?>
      </tbody>
     </table>
</div>
     </div>
   </body>
   </html>
