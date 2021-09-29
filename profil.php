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
   $_SESSION['pseudo'] = $userinfo['pseudo'];
   $_SESSION['nom'] = $userinfo['nom'];

   






?>


<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="styleprofile.css">
   <title>Profil</title>
</head>
<body>
   <div id="info" align="center">
      <img src="logo/logo_gbaf" alt="gbaf" id="gbaf">
   <h1><?= $userinfo['nom'] ?> <?= $userinfo['prenom'] ?></h1>
   <h2>Votre pseudo</h2>
   <br />
   <h3><?= $userinfo['pseudo'] ?></h3>
   <a href="changepseudo.php"> Changer son pseudo</a>
   <br />
   <h2>Votre question secréte</h2>
   <br />
   <h3><?= $userinfo['question'] ?></h3>
   <br />
   <h2>Votre réponse secréte</h2>
   <br />
   <h3><?= $userinfo['reponse'] ?></h3>
      <a href="changequestion.php"> Changer sa question</a>
      <br />

   
   <a href="deconnexion.php"> Se déconnecter </a>
   <br />
   <a href="changementmdp.php"> Changer son mot de passe</a>
   </div>

</body>
<?php } ?>
</html>