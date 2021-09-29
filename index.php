<?php 
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=articles', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$articles = $bdd->query('SELECT * FROM articles ORDER BY id DESC');

?>

<?php 


$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


{
	$getid = intval($_SESSION['id']);
	$requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();
	$_SESSION['id'] = $userinfo['id'];
    



	



?>










<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="stylemain.css">
	<title>Accueil</title>
</head>
<header>
		<p id="info"><a  href="profil.php"><?php echo $userinfo ['nom']; ?>
        <?php echo $userinfo ['prenom']; ?></a>
        <br />
        <a  href="deconnexion.php"> Se déconnecter </a></p>
</header>


<?php 
}
?>
<header><img src="logo/logo_gbaf" alt="gbaf" id="gbaf"></header>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<HR size=2 align=center width="100%" />
<body>

	
	<div id="presentation" align="center" >
      <h1>GBAF</h1>
      <br />

      <p> Le Groupement Banque Assurance Français est une fédération représentant
      	les 6 grands groupes français : 
      		<ul type="none" id="groupement">
      			<li>BNP Paribas</li>
      			<li>BPCE</li>
      			<li>Crédit Agricole</li>
      			<li>CIC</li>
      			<li>Société Générale</li>
      			<li>La Banque Postale</li>
      		
      		</ul>
      	</p>
      <br /><br />
      <img src="logo/illubanque" id="illu" alt="illustrationbanque">

   </div>

   <br /><br /><br /><br /><br />

   <div class="acteurs">
   	<h2 align="center">Acteurs</h2>
   	<HR size=2 align=center width="100%" />
	<ul type="none"  >
		<?php while($a = $articles->fetch()) { ?>

		<li>
			<img id="logoacteur" src="miniatures/<?= $a['id'] ?>.png"/>
			<h3><a href="articles.php?id=<?= $a['id']?>"><?= $a['titre'] ?></a></h3>
			<p><?= substr($a['contenu'], 0, 200) ?>...<a href="articles.php?id=<?= $a['id']?>">Voir la suite</a></p>
			<HR size=2 align=center width="75%" />
		</li>
		<?php } ?>
	</ul>
	</div>

</body>
</html>
