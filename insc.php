<?php 
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $nom = htmlspecialchars($_POST['nom']);
   $prenom = htmlspecialchars($_POST['prenom']);
   $mdp = sha1($_POST['mdp']);
   $question = htmlspecialchars($_POST['question']);
   $reponse = htmlspecialchars($_POST['reponse']);
}


   
   if(!empty($_POST['pseudo'])
    AND !empty($_POST['nom']) 
      AND !empty($_POST['prenom']) 
         AND !empty($_POST['mdp']) 
            AND !empty($_POST['question']) 
               AND !empty($_POST['reponse'])){
      $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, nom, prenom, motdepasse, question, reponse) VALUES(?, ?, ?, ?, ?, ? )");
      
      $insertmbr->execute(array($pseudo, $nom, $prenom, $mdp, $question, $reponse));
      $erreur = "Votre compte a bien été créé ! <a href=\"connex.php\">Me connecter</a>";
}
   
      


?>













<html>
   <head>
      <title>Incription</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="styleco.css">
   </head>
   <body> 
        <div class="formulaire" align="center">
          <img src="logo/logo_gbaf" alt="gbaf" id="gbaf">
            <h2>Inscrivez-vous</h2> 
            <br /><br />
            <form method="POST" action="">
               <table>
                  <tr>
                   <td align="right">
                      <label for="pseudo">Pseudo :</label>
                   </td>
                   <td>   
                      <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo">
                   </td>
                  </tr>
                  <tr>
                   <td align="right">
                      <label for="nom">Nom :</label>
                   </td>
                   <td>   
                      <input type="text" placeholder="Votre nom" id="nom" name="nom">
                   </td>
                  </tr>
                  <tr>
                   <td align="right">
                      <label for="prenom">Prénom:</label>
                   </td>
                   <td>   
                      <input type="text" placeholder="Prénom" id="prenom" name="prenom">
                   </td>
                  </tr>
                  <tr>
                   <td align="right">
                      <label for="mdp">Mot de passe :</label>
                   </td>
                   <td>   
                      <input type="password" placeholder="Mot de passe" id="mdp" name="mdp">
                   </td>
                  </tr>
                  <tr>
                   <td align="right">
                      <label for="question">Question secréte:</label>
                   </td>
                   <td>   
                      <input type="text" placeholder="question secréte" id="question" name="question">
                   </td>
                  </tr>
                  <tr>
                   <td align="right">
                      <label for="reponse">Réponse secréte:</label>
                   </td>
                   <td>   
                      <input type="text" placeholder="Réponse" id="reponse" name="reponse">
                   </td>
                  </tr>
                  <tr>
                     <td></td>
                     <td align="center">
                        <br />
                         <input type="submit" name="forminscription" value="Je m'inscris">
                     </td>
                  </tr>
                  </table>
            </form>
         
           <?php 
            if (isset($erreur)) 
            {
                echo '<font color="green">' .$erreur . "</fonts>";
            }
            ?>
         </div>
      </body>
</html>
      