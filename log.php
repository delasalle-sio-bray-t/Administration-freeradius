<?php
//select * from radpostauth where username = ''
include('include/connecter.php');
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
session_start();
$poste = $_POST['poste'];
$date = $_POST['date'];
$date2 = $_POST['date2'];

if(isset($_POST['reject'])){
  $reject ="Access-Reject";
}
if(isset($_POST['accept'])){
  $accept ="Access-Accept";
}

if ($poste != "" || $date != "" || $date2 != "" || $reject != "" || $accept != ""){

  //**********************************************Cas 1 seul choix**************************************************************
    //Cas ou seulement le poste est selectionné
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']== "" && $_POST['reject'] == "" && $_POST['accept'] == ""){
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' ORDER BY id DESC");
  }

    //Cas ou seulement la date1 est selectionné
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] == "" && $_POST['accept'] == ""){
    $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where authdate LIKE '$date' ORDER BY id DESC");
  }

  //Cas ou seulement la date2 est selectionné
  if ($_POST['poste'] =="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] == ""){
    $date2 = $date2."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where authdate LIKE '$date2' ORDER BY id DESC");  }

  //Cas ou seulement la checkbox1 est selectionné
  if ($_POST['poste'] =="" && $_POST['date'] == "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$reject' ORDER BY id DESC");
  }

  //Cas ou seulement la checkbox2 est selectionné
  if ($_POST['poste'] =="" && $_POST['date'] == "" && $_POST['date2']== "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$accept' ORDER BY id DESC");
  }

  //**********************************************Cas 2 choix*********************************************************************
  //Cas poste + date
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] == "" && $_POST['accept'] == ""){
        $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' and authdate LIKE '$date' ORDER BY id DESC");
  }
  //Cas poste + date 2
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] == ""){
        $date2 = $date2."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' and authdate LIKE '$date2' ORDER BY id DESC");
  }
  //Cas poste + checkbox1
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' and reply = '$reject' ORDER BY id DESC");
  }
  //Cas poste + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']== "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' and reply = '$accept' ORDER BY id DESC");
  }
  //Cas date1 + checkbox1
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
      $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$reject' and authdate LIKE '$date' ORDER BY id DESC");
  }
  //Cas date1 + checkbox2
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $date = $date."%";
  $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$accept' and authdate LIKE '$date' ORDER BY id DESC");
  }
  //Cas date1 + date2
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] == ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
  }
  //Cas date2 + checkbox1
  if ($_POST['poste'] =="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
    $date2 = $date2."%";
  $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$reject' and authdate LIKE '$date2' ORDER BY id DESC");
  }
  //Cas date2 + checkbox2
  if ($_POST['poste'] =="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $date2 = $date2."%";
  $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$accept' and authdate LIKE '$date2' ORDER BY id DESC");
  }
  //Cas checkbox1 + checkbox2
  if ($_POST['poste'] =="" && $_POST['date'] == "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
  $req_pre_log = $cnx->prepare("SELECT * from radpostauth ORDER BY id DESC");
  }

  //**********************************************Cas 3 choix*********************************************************************
  //Cas poste + date + date2
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] == ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' AND authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
  }
  //Cas poste + date + checkbox1
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
    $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' AND authdate LIKE '$date' AND reply = '$reject' ORDER BY id DESC");
  }
  //Cas poste + date + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' AND authdate LIKE '$date' AND reply = '$accept' ORDER BY id DESC");
  }
  //Cas poste + date2 + checkbox1
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
    $date2 = $date2."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' AND authdate LIKE '$date2' AND reply = '$reject' ORDER BY id DESC");
  }
  //Cas poste + date2 + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $date2 = $date2."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' AND authdate LIKE '$date2' AND reply = '$accept' ORDER BY id DESC");
  }
  //Cas poste + checkbox1 + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' ORDER BY id DESC ");
  }
  //Cas date + date2 + checkbox1
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$reject' AND authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
  }
  //Cas date + date2 + checkbox2
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where reply = '$accept' AND authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
  }
  //Cas date + checkbox1 + checkbox2
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
    $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where authdate LIKE '$date' ORDER BY id DESC");
  }
  //Cas date2 + checkbox1 + checkbox2
  if ($_POST['poste'] =="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
    $date2 = $date2."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where authdate LIKE '$date2' ORDER BY id DESC");
  }
  //**********************************************Cas 4 choix*********************************************************************
  //Cas poste + date1 + date2 + checkbox1
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] == ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username ='$poste' AND reply = '$reject' AND authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
  }
  //Cas poste + date1 + date2 + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] == "" && $_POST['accept'] != ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username ='$poste' AND reply = '$accept' AND authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
  }
  //Cas poste + date1 + checkbox1 + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']== "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
    $date = $date."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' AND authdate LIKE '$date' ORDER BY id DESC");
  }
  //Cas poste + date2 + checkbox1 + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] == "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
    $date2 = $date2."%";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where username = '$poste' AND authdate LIKE '$date2' ORDER BY id DESC");
  }
  //Cas  date1 + date2 + checkbox1 + checkbox2
  if ($_POST['poste'] =="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth where authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
  }
  //**********************************************Cas 5 choix*********************************************************************
  //Cas poste + date1 + date2 + checkbox1 + checkbox2
  if ($_POST['poste'] !="" && $_POST['date'] != "" && $_POST['date2']!= "" && $_POST['reject'] != "" && $_POST['accept'] != ""){
    $date = $date." 00:00:00";
    $date2 = $date2." 23:59:59";
    $req_pre_log = $cnx->prepare("SELECT * from radpostauth WHERE username = '$poste' and authdate BETWEEN '$date' AND '$date2' ORDER BY id DESC");
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
      <script src="https://use.fontawesome.com/12f930d229.js"></script>

      <script src="include/jquery/jquery-ui.js"></script>
      <script>
      $( function() {
        $( "#date" ).datepicker();
        $( "#date2" ).datepicker();
      } );
      </script>
      <style>
      .tableau tr:nth-child(3) > td:nth-child(2) {
    border-top: none;
    border-bottom: none;
}
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
     <form enctype="multipart/form-data" action="log.php" method="post">
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
              <tr><td><p>

              Access-Reject<input type="checkbox" name="reject" id="reject" /></p></td><td><p>

              Access-Accept<input type="checkbox" name="accept" id="accept" /></p></td><td><input type="submit" value="Rechercher"></td></tr>
           </table>
           </form>
           <div id="scrolltable">


                <table class="tableauLog">
                  <thead>
                    <th>Adresse MAC</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Ajouter le poste</th>
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
                      <td><?php echo utf8_encode($ligne->username); ?></td>
                      <td><?php echo utf8_decode($ligne->reply); ?></td>
                      <td><?php echo utf8_decode($ligne->authdate); ?></td>
                      <td><a style="color : black;" href="ajouter_poste.php?mac=<?php echo $mac;  ?>"><i class="fa fa-plus fa-3" aria-hidden="true"></i></a></td>
                    </tr>
                  <?php
                  $ligne=$req_pre_log->fetch(PDO::FETCH_OBJ);
                }
                 ?>
                </tbody>
                </table>

         </body>
       </html>
