<?php 
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['formconnexion']))
{
    $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if (!empty($pseudoconnect) AND !empty($mdpconnect))
    {
        $requser = $bdd->prepare("SELECT * FROM  membres WHERE pseudo = ? AND motdepasse = ?");
        $requser->execute(array($pseudoconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION ['prenom'] = $userinfo['prenom'];
            header("Location: index.php");
        }
        else
        {
            $erreur = "Pseudo ou mot de passe incorrect";
        }
        
    }
}
?>
    
    








<html>
   <head>
      <title>Connexion</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="styleco.css">
   </head>
   <body> 
        <div class="formulaire" align="center">
            <img src="logo/logo_gbaf" alt="gbaf" id="gbaf">
            <h2>Connexion</h2> 
            <br /><br />
            <form method="POST" action="">
                 <input type="text" name="pseudoconnect" placeholder = "Pseudo" />
                 <br /> <br />
                 <input type="password" name="mdpconnect" placeholder = "Mot de passe" />
                 <br /> <br />
                 <input type="submit" name="formconnexion" value="Se connecter" />
                 <br />   
            </form>
            <a href="insc.php">Inscription</a>
            <br />
            <a href="pseudo.php">Mot de passe oublié ?</a>
            <br /> <br />
           <?php 
            if (isset($erreur)) 
            {
                echo '<font color="red">' .$erreur . "</fonts>";
            }
            ?>
         </div>     
   </body>
</html>