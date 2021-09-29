<?php 
$bdd = new PDO('mysql:host=localhost;dbname=articles', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['article_titre'], $_POST['article_contenu']))
{
	if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu']));
	{
		$article_titre = htmlspecialchars($_POST['article_titre']);
		$article_contenu = htmlspecialchars($_POST['article_contenu']);

		var_dump($_FILES);
		var_dump(exif_imagetype($_FILES['miniature']['tmp_name']));


		 $ins = $bdd->prepare('INSERT INTO articles (titre, contenu)
			VALUES (?, ?)');
		 $ins->execute(array($article_titre, $article_contenu));
		 $lastid = $bdd->lastInsertId();

		if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) 
		{
			if (exif_imagetype($_FILES['miniature']['tmp_name']) == 3)
			{
				$chemin = 'miniatures/' .$lastid. '.png';
				move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);

			} 
			else 
			{
				$message ='PNG ONLY';
			}
		}
	}
}






?>













<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rédaction</title>
</head>
<body>

	<form method="POST" enctype="multipart/form-data">
		<input type="text" placeholder="titre" name="article_titre">
		<br />
		<textarea placeholder="Contenu" name="article_contenu"></textarea>
		<br />
		<input type="file" name="miniature" />
		<br />
		<input type="submit" value="envoyer l'article">
	</form>

</body>
</html>