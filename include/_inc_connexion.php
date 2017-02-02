<?php
try
{
	$cnx = new PDO('mysql:host='.$HOTE.';port='.$PORT.';dbname='.$BDD,$USER,$PWD);
}
catch (Exception $e)
{
	echo 'Erreur : '.$e->getMessage().'</br/>';
	echo 'N° : '.$e->getCode();
}						
?>