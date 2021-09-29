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
	

	if(isset($_POST['valid'])) 
	{
		$nquestion = htmlspecialchars($_POST['newquestion']);
		$nreponse = htmlspecialchars($_POST['newreponse']);

		if (!empty($nquestion) AND !empty($nreponse))
		{
			$requser = $bdd->prepare("SELECT * FROM  membres 
				WHERE id = ?");
        	$requser->execute(array($_SESSION['id']));
        	$userexist = $requser->rowCount();
        	if($userexist == 1)
        	
        		$requser = $bdd->prepare('UPDATE membres SET question = ?, reponse = ?  WHERE id = ? ');
        		$requser->execute(array($nquestion,$nreponse,$_SESSION['id']));
        	
		}
	}
    



	



?>













<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styleco.css">
	<title>Changement de question</title>
</head>
<body>
	<div class="formulaire" align="center">
		 <img src="logo/logo_gbaf" alt="gbaf" id="gbaf">
	<form method="POST" action="">
		<input type="text" name="newquestion" placeholder = "Nouvelle question" />
		<input type="text" name="newreponse" placeholder = "Nouvelle reponse" />
		<br /> <br />
		<input type="submit" name="valid" value="Valider" />
		<br /> <br /> 
		<?php } ?>


	









	</form>
	</div>



</body>
</html>