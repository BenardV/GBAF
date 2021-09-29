<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
{
	$getid = intval($_SESSION['id']);
	$requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();
	$_SESSION['id'] = $userinfo['id'];
	

	if(isset($_POST['pseudovalid']))
	{
		$nouveaupseudo = htmlspecialchars($_POST['newpseudo']);
		if (!empty($nouveaupseudo))
		{
			$requser = $bdd->prepare("SELECT * FROM  membres 
				WHERE id = ?");
        	$requser->execute(array($_SESSION['id']));
        	$userexist = $requser->rowCount();
        	if($userexist == 1)
        	
        		$requser = $bdd->prepare('UPDATE membres SET pseudo = ? WHERE id = ? ');
        		$requser->execute(array($nouveaupseudo,$_SESSION['id']));

		}
	}
    



	



?>













<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styleco.css">
	<title>Changement de pseudo</title>
</head>
<body>
	<div class="formulaire" align="center">
		 <img src="logo/logo_gbaf" alt="gbaf" id="gbaf">
	<form method="POST" action="">
		<input type="text" name="newpseudo" placeholder = "nouveau pseudo" />
		<br /> <br />
		<input type="submit" name="pseudovalid" value="Valider" />
		<br /> <br /> 
		<?php } ?>


	









	</form>
	</div>



</body>
</html>