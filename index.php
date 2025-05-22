<?php
require_once("_conf.php");
include("_conf.php");
// on se connecte à MySQL 
if ($connexion = mysqli_connect($serveur, $user, $pwd, $bdd)) {


  //on oublie pas de fermer la connexion
  mysqli_close($connexion);
} else // Mais si elle rate
{
  echo 'Erreur'; // On affiche un message d'erreur
}

?>
<form action="accueil.php" method="post">
  <fieldset style="background: #f8f0ff; border: 6px solid #9238ca;">
    <legend>Connexion</legend>
    <input type="text" name="login" placeholder="login" required><br /><br />
    <input type="password" name="mot de passe" placeholder="mot de passe" required><br /><br />

    <button name="send_con" type="submit">Submit</button>
  </fieldset>

</form>
<pre>
<a href="inscription.php"> Inscription </a>
</pre>
<a href="oubli.php"> oubli de mots de passe </a>