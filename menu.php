<?php include('include/connecter.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css">
    <style>

	    html {
	      height: 100%;
	    }
	    body {
	      font: 0.8em Verdana, Arial, Helvetica, sans-serif;
	      margin: 0;
	      padding: 30px 0 0 0;
	      background: -moz-linear-gradient(top, rgb(255, 255, 255), rgb(210, 210, 210));
	      background: -webkit-gradient(linear, left top, left bottom, from(rgb(255, 255, 255)), to(rgb(210, 210, 210)));
	      background: linear-gradient(to bottom, rgb(255, 255, 255), rgb(210, 210, 210));
	    }
	    div#page {
	      width: 800px;
	      margin: 0px auto;
	      padding: 0;
	      border: #000 1px solid;
	      text-align: left;
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
	    /* menu vertical */
	    div#menu-vertical {

	    }
	    div#menu-vertical a.bouton-menu:hover{
	    	background: -moz-linear-gradient(top,rgb(255,255,255), rgb(200,200,200));
	    	background: -webkit-gradient(linear, right top, right bottom, from(rgb)(255,255,255), to(rgb(200,200,200)));
	    	background: linear-gradient(to bottom,rgb(255,255,255), rgb(200,200,200));
	    }
	    a.bouton-menu {
	    	font: 1.1em Arial, Helvetica, sans-serif;
	    	margin: 20px auto;
	    	display: block;
	    	width: 300px;
	    	background: #ccc;
	    	text-align: center;
	    	text-decoration: none;
	    	color: #0b4c8e;
	    	font-weight: bold;
	    	padding: 5px;
	    	-moz-border-radius: 7px;
	    	-webkit-border-radius: 7px;
	    	-o-border-radius: 7px;
	    	-ms-border-radius: 7px;
	    	-khtml-border-radius: 7px;
	    	border-radius: 7px;
	    	background: -moz-linear-gradient(top, rgb(255, 255, 255), rgb(210, 210, 210));
	    	background: -webkit-gradient(linear, right top, right bottom, from(rgb(255, 255, 255)), to(rgb(210, 210, 210)));
	    	background: linear-gradient(to bottom, rgb(255, 255, 255), rgb(210, 210, 210));
	    	text-shadow: 0 1px 0 #fff;
	    	border: 1px solid rgba(0, 0, 0, 0.1);
	    	-webkit-box-shadow: 2px 2px 2px 0px rgba(0, 0, 0, 0.3);
	    	-moz-box-shadow: 2px 2px 2px 0px rgba(0, 0, 0, 0.3);
	    	-o-box-shadow: 2px 2px 2px 0px rgba(0, 0, 0, 0.3);
	    	box-shadow: 2px 2px 2px 0px rgba(0, 0, 0, 0.3);
	    }
	    div#content h2 {

	      text-align: center;
	    	font-size: 1.4em;
	    	color: #0b4c8e;
	    	line-height: 25px;
	    	border-bottom: #0b4c8e 1px solid;
	    }
    </style>
	</head>
	<body>
		<div id="page">
      <div id="content">
			<h2>Administration serveur Radius</h2>
				<div id="menu-vertical">
					<p><a href="ajouter_poste.php" class="bouton-menu">Gérer les postes</a></p>
					<p><a href="vlan.php" class="bouton-menu">Gérer les VLANs</a></p>
          <p><a href="log.php" class="bouton-menu">Logs des connexions</a></p>
					<p><a href="enCours.php?req=co" class="bouton-menu">Postes connectés</a></p>
					<p><a href="logAccounting.php" class="bouton-menu">Logs Accounting</a></p>
				</div>
			</div>
    </div>
  </body>
</html>
