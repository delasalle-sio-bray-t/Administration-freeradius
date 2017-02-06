<?php
//select * from radpostauth where username = ''
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
include('include/connecter.php');
session_start();
include("include/fonction.php");
updateVlan();

?>

<html>

   <head>
     <title>Administration</title>
      <meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css">
   </head>
   <body>
     <div id="page">


     <a href="menu.php" class="bouton-menu">Accueil</a>
     <p><?php echo $_SESSION['rep'];
     $_SESSION['rep'] = "";
      ?></p>

     <form enctype="multipart/form-data" action="ajouter_vlan.php" method="post">
      <table class="tableau">
          <tr>
            <th>Numéro du VLAN</th>
            <th>Nom du VLAN</th>
          </tr>
         <tr>
           <td><input type="number" name="num" id="num" min="10" max="1000" required ></td>
           <td><input type="text" name="nom" id="nom" maxlength="12" placeholder="" required ></td>
         </tr>

         <tr>
           <td><input type="radio" name="vlanRadio" value="true" id="VlanSwitch"/><label for="VlanSwitch" >VLAN déjà sur le switch </label><br />
           <input type=radio name="vlanRadio" value="false" id="pasVlanSwitch" /><label for="pasVlanSwitch" >Nouveau VLAN</label></td>
           <td><input type="submit" value="Envoyer"></td>
          </tr>
      </table>
      <table>
        <table class="tableau1">
        <thead>
          <tr>
              <th>Nom du VLAN</th>
              <th>Numéro du VLAN</th>
              <th>Supprimer</th>
            </tr>
        </thead>

<?php
           $req_pre = $cnx->prepare("SELECT * from radgroupreply WHERE attribute = 'Tunnel-Private-Group-id' ORDER BY value ASC");
$req_pre->execute();
//le résultat est récupéré sous forme d'objet
$ligne=$req_pre->fetch(PDO::FETCH_OBJ);
$i = 1;




while ($ligne) // On fait une oucle pour postes
{

//On recupere le groupe du poste dans la table radusergroup en fonction de son ID
$idVlan = $ligne->id;



$i = $i + 3;
?>
<tr>
<td><?php echo $ligne->groupname; ?></td>
<td><?php echo $ligne->value; ?></td>
<td><?php echo '<a href="supprimerVlan.php?supprimer_vlan='.$ligne->id.'">'; ?><img src="img/trash.png" width="20px" height="20px"></a></td>
</tr>
<?php

  $ligne=$req_pre->fetch(PDO::FETCH_OBJ);

} ?>

        </table>

      </table>

</div>
</body>

</html>
