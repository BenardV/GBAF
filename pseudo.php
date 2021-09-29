<?php 
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['formmdp']))
{
    $pseudomdp = htmlspecialchars($_POST['pseudomdp']);
    if (!empty($pseudomdp))
    {
        $requser = $bdd->prepare("SELECT * FROM  membres WHERE pseudo = ?");
        $requser->execute(array($pseudomdp));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION ['prenom'] = $userinfo['prenom'];
            header("Location: changementmdp.php?id=" .$_SESSION['id']);
        }
    }
}
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" href="styleco.css">
	<title>Pseudo</title>
</head>
<body>

    <div align="center" class="formulaire">
         <img src="logo/logo_gbaf" alt="gbaf" id="gbaf">
         <h1>Entrez votre pseudo</h1>
	<form method="POST" action="">
                 <input type="text" name="pseudomdp" placeholder = "Pseudo" />
                 <br /> <br /> 
                 <input type="submit" name="formmdp" value="Continuer" />
                 <br /> <br />    
            </form>
    </div>
</body>
</html>