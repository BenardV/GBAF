

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
('SELECT *, membres.prenom as `alias1`, DATE_FORMAT(date_time, "%d/%m/%y %h:%i") as `date_com` FROM commentaires LEFT JOIN membres ON commentaires.id_membre = membres.id WHERE id_article = ?');
$commentaires->execute(array($id));


	if (isset($_POST['submit_com'])) 
	{
		if(isset($_POST['commentaire']) AND !empty($_POST['commentaire'])) 
		{
			$commentaires = htmlspecialchars($_POST['commentaire']);
			$sessionid = $_SESSION['id'];

			$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$requser = $bdd->prepare
			('SELECT id FROM membres WHERE id = ?');
			$requser->execute(array($sessionid));
			$userinfo = $requser->fetch();
			$sessionid = $userinfo ['id'];
			$getid = (int) $_GET['id'];

			$check_com = $bdd->prepare('SELECT id FROM commentaires WHERE id_article = ? AND id_membre = ?');
			$check_com->execute(array($getid, $sessionid));

			if($check_com->rowCount() == 1)
			{
				$del = $bdd->prepare('DELETE FROM commentaires WHERE id_article = ? AND id_membre = ?');
				$del->execute(array($getid, $sessionid));

				$ins = $bdd->prepare('INSERT INTO commentaires (commentaire, id_article, id_membre) VALUES (?, ?, ?) ');
				$ins->execute(array($commentaires, $id,$sessionid));
				header("Refresh:1");


			
			}
			else
			{
				$ins = $bdd->prepare('INSERT INTO commentaires (commentaire, id_article, id_membre) VALUES (?, ?, ?) ');
				$ins->execute(array($commentaires, $id,$sessionid));
				header("Refresh:1");
			}
			
			 
			
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
	<HR size=2 align=center width="100%" />

<div id="membreaction">
	<div id="likedislike" align="right" id="like">
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
	


	</form>
	<br />
	<?php while($c = $commentaires->fetch()) { ?>
		<div id="comment">
		<ul type="none">
			<span id="pseudo"> 
		<li><h3 align="left"><?= $c['alias1'] ?></h3>
			<p align="left"><?= date("d/m/Y H:i",strtotime($c['date_time']) ) ?></p>
			</span>
			<br />
			<h4 id="contenucom" align="left"><?= $c['commentaire'] ?></h4> <br /></li>
		</ul>
		</div>


	<?php } ?>

	</div>
	
	



</body>
</html>