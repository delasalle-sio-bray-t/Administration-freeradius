<?php
include('include/connecter.php');
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
include("include/switch.php");

session_start();
if (isset($_POST['num']) AND isset($_POST['nom'])){

$ip = $globals['ip'];
$Username = $globals['utilisateur'];
$password = $globals['mdp'];
$enPass = $globals['enable'];
$numVlan = $_POST['num'];
$nomVlan = $_POST['nom'];
$p = '$p';

//Vérification de si l'adresse mac n'existe pas déjà
$req_pre = $cnx->prepare("SELECT count(*) as nb FROM radgroupreply where value = '$numVlan' OR groupname = '$nomVlan' AND attribute = 'Tunnel-Private-Group-Id'");
$req_pre->execute();
$nb = $req_pre->fetchColumn(0);



//Si l'adresse mac est déjà dans la base
if ($nb != 0){
  $_SESSION['rep'] = "Erreur, le vlan existe déjà. ";
  header("Location: vlan.php");


}
else {

  //Préparation de la requete d'insertion de l'utilisateur

  $req_pre = $cnx->prepare("INSERT into radgroupreply (groupname, attribute, op, value) values (:nom, 'Tunnel-Private-Group-Id', '=', :num),
  (:nom, 'Tunnel-Type', '=', '13'),
  (:nom, 'Tunnel-Medium-Type', '=', '6');");
  // liaison de la variable à la requête préparée
  $req_pre->bindValue(':num', $numVlan, PDO::PARAM_STR);
  $req_pre->bindValue(':nom', utf8_decode($nomVlan), PDO::PARAM_STR);
  $req_pre->execute();

  if ($_POST['vlanRadio'] == "true"){



  $results = shell_exec("expect script/scriptCreaVlan.sh $ip $Username $password $enPass $numVlan $nomVlan | head -n -3 | tail -n +24 ");
  //echo "<pre>".$results . "</pre>";

}


  header("Location: vlan.php");


}

/*
INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES
(1, 'invit', 'Tunnel-Private-Group-Id', '=', '10'),
(2, 'invit', 'Tunnel-Type', '=', '13'),
(3, 'invit', 'Tunnel-Medium-Type', '=', '6'),
//$results = shell_exec("expect ../script/scriptCreaVlan.sh $ip $Username $password $numVlan $nomVlan | sed -n '23,$p' ");
$results = shell_exec("expect ../script/scriptCreaVlan.sh $ip $Username $password $numVlan $nomVlan | head -n -3 | tail -n +24 ");
echo "<pre>".$results . "</pre>";

*/

}

?>
