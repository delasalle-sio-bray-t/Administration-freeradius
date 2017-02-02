<?php
include("include/_inc_parametres.php");
include('include/connecter.php');
include("include/_inc_connexion.php");
session_start();

$login = $_POST['user'];
$mdp = sha1($_POST['password']);

$req_pre = $cnx->prepare("SELECT COUNT(*) from raduser where login = :login and password = :mdp");
$req_pre->bindValue(':login', $login, PDO::PARAM_STR);
$req_pre->bindValue(':mdp', $mdp, PDO::PARAM_STR);
$req_pre->execute();
$nb = $req_pre->fetchColumn(0);

if ($nb == 1){

  $_SESSION['login'] = "true";
//  echo "ok";
  //echo $_SESSION['login'];
 header("Location: menu.php");
}
else {
//  echo "pasok";
  header("Location: index.php");
}
