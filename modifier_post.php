<?php
include('include/connecter.php');
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
session_start();

$id = $_SESSION['id'];
$nom = $_POST['nom'];
$mac = $_POST['mac'];
$groupe = $_POST['groupe'];

if ( preg_match( '/[0-9a-f]{12}$/i', $mac) ){
  //Vérification de si l'adresse mac n'existe pas déjà
  $req_pre = $cnx->prepare("SELECT count(*) as nb FROM radcheck where username = '$mac'");
  $req_pre->execute();
  $nb = $req_pre->fetchColumn(0);



  //Si l'adresse mac est déjà dans la base
  if ($nb != 0){
    $_SESSION['rep'] = "Erreur, l'adresse mac : ".$mac." existe déjà . ";
    header("Location: ajouter_poste.php");


  }
  else {
  //Préparation de la requete de modification de l'utilisateur
  $req_pre = $cnx->prepare("UPDATE radcheck SET username = :mac, machine = :nom WHERE id = :id");
  // liaison de la variable à la requête préparée
  $req_pre->bindValue(':mac', $mac, PDO::PARAM_STR);
  $req_pre->bindValue(':nom', utf8_decode($nom), PDO::PARAM_STR);
  $req_pre->bindValue(':id', $id, PDO::PARAM_INT);
  $req_pre->execute();


  //Recupération de l'id de la machine
  $req_pre = $cnx->prepare("SELECT id FROM radcheck WHERE username = '$mac' ");
  $req_pre->execute();
  //le résultat est récupéré sous forme d'objet
  $id =$req_pre->fetchColumn(0);

  //Préparation de la requete de modification dans radusergroup
  $req_pre = $cnx->prepare("UPDATE radusergroup SET username = :mac, groupname = :groupe where id = :id");
  $req_pre->bindValue(':id', $id, PDO::PARAM_INT);
  $req_pre->bindValue(':mac', $mac, PDO::PARAM_STR);
  $req_pre->bindValue(':groupe', $groupe, PDO::PARAM_STR);
  $req_pre->execute();

  header("Location: ajouter_poste.php");
  }
}
  //Si l'adresse mac n'est pas valide
else {
   $_SESSION['rep'] = "Erreur pour l'adresse mac : ".$mac;
   header("Location: ajouter_poste.php");

}
