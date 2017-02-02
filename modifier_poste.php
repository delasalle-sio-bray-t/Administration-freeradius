<?php
include('include/connecter.php');
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
session_start();

    if (isset($_GET['modifier_poste'])) // Si l'on demande de supprimer un poste
     {
       //
       $_GET['modifier_poste'] = addslashes($_GET['modifier_poste']);
       $id = $_GET['modifier_poste'];
       $_SESSION['id'] = $id;
       $req_pre = $cnx->prepare("SELECT * FROM radcheck WHERE id = $id");
       $req_pre->execute();
       //le résultat est récupéré sous forme d'objet
       $ligne=$req_pre->fetch(PDO::FETCH_OBJ);
       $adr_mac = utf8_encode($ligne->username);
       $nom_machine = utf8_encode($ligne->machine);

       $req_pre = $cnx->prepare("SELECT * FROM radusergroup WHERE id =$id");
       $req_pre->execute();
       //le résultat est récupéré sous forme d'objet
       $ligne=$req_pre->fetch(PDO::FETCH_OBJ);
       $groupe = utf8_decode($ligne->groupname);


     ?>

<html>

   <head>
     <title>Administration</title>
      <meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css">
   </head>

   <body>

     <form enctype="multipart/form-data" action="modifier_post.php" method="post">
      <table class="tableau">
          <tr>
            <th>Nom de l'équipement</th>
            <th>Adresse MAC</th>
          </tr>
         <tr>
           <td><input type="text" name="nom" id="nom" maxlength="19" required value="<?php echo $nom_machine; ?>" ></td>
           <td><input type="text" name="mac" id="mac" maxlength="12" placeholder="11aa22bb33cc" required value="<?php echo $adr_mac; ?>"></td>
         </tr>

         <tr><td>
           <?php
           $req_pre_list = $cnx->prepare("SELECT * from radgroupreply");
           $req_pre_list->execute();
           $ligne=$req_pre_list->fetch(PDO::FETCH_OBJ);
          // $idVlan = $ligne->id;
           $i = 1;

           ?>
             <select name="groupe">
               <?php

               while ($ligne) {

                  $idVlan = $ligne->id;

                 if ($idVlan == $i) {
                  echo '<option value="'.$ligne->groupname.'">'.$ligne->groupname.'</option>';
                  $i = $i + 3;
                 }
                 $ligne=$req_pre_list->fetch(PDO::FETCH_OBJ);

               }


               ?>

             </select>
         </td>
           <td><input type="submit" value="Envoyer"></td>
          </tr>
      </table>

    </body>
</html>
<?php
} else {

    header("Location: ajouter_poste.php");
} ?>
