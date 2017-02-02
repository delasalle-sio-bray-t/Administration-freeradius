<?php

function updateVlan(){
  include("_inc_parametres.php");
  include("_inc_connexion.php");
  $req_pre = $cnx->prepare("SELECT count(*) as nb from radgroupreply");
  $req_pre->execute();
  $nb = $req_pre->fetchColumn(0);

  $req_pre = $cnx->prepare("SELECT id from radgroupreply");
  $req_pre->execute();
  $ligne = $req_pre->fetch(PDO::FETCH_OBJ);
  for ($i=0; $i < $nb ; $i++) {
    $j = $i + 1;
  $modif = $cnx->exec("update radgroupreply set id = $j where id = $ligne->id");
  $ligne = $req_pre->fetch(PDO::FETCH_OBJ);

  }
}
updateVlan();
?>
