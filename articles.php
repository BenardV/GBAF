

<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_GET['id']) AND !empty($_GET['id'])) 
{
	$get_id=htmlspecialchars($_GET['id']);

	$article = $bdd->prepare('SELECT * FROM articles WHERE id =?');
	$article->execute(array($get_id));

	if($article->rowCount() == 1) 
	{
		$article = $article->fetch();
		$id = $article['id'];
		$titre = $article['titre'];
		$contenu = $article['contenu'];

		$likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
		$likes->execute(array($id));
		$likes = $likes->rowCount();

		$dislikes = $bdd->prepare




		('SELECT id FROM dislikes WHERE id_article = ?');
		$dislikes->execute(array($id));
		$dislikes = $dislikes->rowCount();

	}
}
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$commentaires = $bdd->prepare
('SELECT *, membres.prenom as `alias1` FROM commentaires LEFT JOIN membres ON commentaires.id_membre = membres.id WHERE id_article = ?');
$commentaires->execute(array($id));


	if (isset($_POST['submit_com'])) 
	{
		if(isset($_POST['commentaire']) AND !empty($_POST['commentaire'])) 
		{
			$commentaire = htmlspecialchars($_POST['commentaire']);
			$sessionid = $_SESSION['id'];

			$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$requser = $bdd->prepare
			('SELECT id FROM membres WHERE id = ?');
			$requser->execute(array($sessionid));
			$userinfo = $requser->fetch();
			$sessionid = $userinfo ['id'];


			$ins = $bdd->prepare('INSERT INTO commentaires (commentaire, id_article, id_membre) VALUES (?, ?, ?) ');
			$ins->execute(array($commentaire, $id,$sessionid));
			 
			
		}
	}


?>










<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="stylearticle.css">
	<title></title>
</head>
<body>
	<img align="center" src="logo/logo_gbaf" alt="gbaf" id="gbaf">
	<HR size=2 align=center width="100%" />

	<div id="acteur" align="center">
	<h1><?= $titre ?></h1>
	<img src="miniatures/<?= $article['id'] ?>.png"/>
	<p><?= $contenu ?></p>
	</div>


	<div align="center" id="like">
	<a href="php/action.php?t=1&id=<?= $id ?>"> J'aime </a>(<?= $likes ?>)
	<a href="php/action.php?t=2&id=<?= $id ?>"> Je n'aime pas </a>
	(<?= $dislikes ?>)
	<br />
	</div>
	<div align="center" id="com">
	<h2>Commentaires</h2>
	<form method="POST">
		<textarea name="commentaire" placeholder="Votre commentaire.."></textarea>
		<br />
		<input type="submit" name="submit_com" value="Envoyer">
		</div>
	<HR size=2 align=center width="100%" />


	</form>
	<br />
	<?php while($c = $commentaires->fetch()) { ?>
		<div id="comment">
		<ul type="none">
		<li><h3><?= $c['alias1'] ?></h3>
			<p><?= $c['date_time'] ?><p>
			<br />
			<h4 id="contenucom" align="center"><?= $c['commentaire'] ?></h4> <br /></li>
		</ul>
		</div>

	<?php } ?>
	
	



</body>
</html>