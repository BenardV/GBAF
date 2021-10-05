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
	

	if(isset($_POST['mdpvalid']))
	{
		$repsecrete = htmlspecialchars($_POST['reponse']);
		$newmdp = sha1($_POST['nouveaumdp']);
		if (!empty($repsecrete) AND !empty($newmdp))
		{
			$requser = $bdd->prepare("SELECT * FROM  membres 
				WHERE reponse = ?");
        	$requser->execute(array($repsecrete));
        	$userexist = $requser->rowCount();
        	if($userexist == 1)
        	{
        		$requser = $bdd->prepare('UPDATE membres SET motdepasse = ? ');
        		$requser->execute(array($newmdp));
        		header("Location: connex.php");
        	}
 			else
 			{
 				$erreur = "Réponse secréte non valide";
 			}
		}
		
	}
    



	



?>













<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styleco.css">
	<title>Changement de mot de passe</title>
</head>
<body>
	<div class="formulaire" align="center">
		 <img src="logo/logo_gbaf" alt="gbaf" id="gbaf">
	<form method="POST">
		<h2><?php echo $userinfo ['question']; ?></h2>
		<input type="text" name="reponse" placeholder = "Réponse secréte" />
		<br /> <br />
		<input type="password" name="nouveaumdp" placeholder = "Nouveau mot de passe" />
		<br /> <br />
		<input type="submit" name="mdpvalid" value="Changer le mot de passe" />
		<br /> <br /> 
		<?php 
            if (isset($erreur)) 
            {
                echo '<font color="red">' .$erreur . "</fonts>";
            }
           ?>
		<?php } ?>


	









	</form>
	</div>



</body>
</html>