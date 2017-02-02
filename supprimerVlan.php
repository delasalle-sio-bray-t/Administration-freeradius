<?php
include('include/connecter.php');
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
include("include/fonction.php");
include("include/switch.php");
session_start();
//Set des variables globlaes
$ip = $globals['ip'];
$password = $globals['mdp'];
$Username = $globals['utilisateur'];
$enPass = $globals['enable'];
$idVlan = $_GET['supprimer_vlan'];


if (isset($_GET['supprimer_vlan'])){

//récupération du numéro de vlan pour le supprimer du NAS
$req_pre = $cnx->prepare("select * from radgroupreply where id = $idVlan ");
//echo "select * from radgroupreply where id = $idVlan ";
$req_pre->execute();
$ligne=$req_pre->fetch(PDO::FETCH_OBJ);
$numVlan = $ligne->value;

$cnx->exec("UPDATE radusergroup set groupname = 'VLAN_non_assigne' where groupname = '$ligne->groupname'");


//$j correspond a la colonne id de la table radgroupreply
$j = $_GET['supprimer_vlan'];
//Boucle pour supprimer les 3 entrées concernant les vlans dans la bdd
for ($i=0; $i < 3 ; $i++) {
$cnx->exec("DELETE FROM radgroupreply WHERE id ='".$j."'");
$j++;
}
//Lancemenent du script
//$results = shell_exec("expect script/scriptSupVlan.sh $ip $Username $password $enPass $numVlan | head -n -3 | tail -n +24 ");
//echo "expect script/scriptSupVlan.sh $ip $Username $password $numVlan | head -n -3 | tail -n +24 ";
//MAJ des id de vlans
updateVlan();
//redirection
header("Location: vlan.php");

}


?>
