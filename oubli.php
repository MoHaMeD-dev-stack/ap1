<?php 
require_once("_conf.php");
if (isset($_POST['email']))
{
     $lemail=$_POST['email'];
     echo "le formulaire a été envoyé avec comme email la valeur :".$lemail."<br>";
	 
	 //connexion BDD
	  if($connexion = mysqli_connect($serveur,$user,$pwd,$bdd))
	 {
		// Si la connexion a réussi 
	
			$requete="Select * from utilisateur WHERE email='$lemail'";
			$resultat = mysqli_query($connexion, $requete);
			$login=0;
			
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				$login =$donnees['login']; //mettre le nom du champ dans la table
			
			}
		//je verifie que l'email est present dans la BDD 
		if($login!=0)
		{
			$pwd = genererMdp(10); // mot de passe temporaire
			$hashed_pwd = md5($pwd);
			
			$message="bonjour, voici votre mot de passe pour vous connecter : $pwd";
			echo "un email vous a été envoyé avec votre mots de passe";
			//IL FAUT UPDATE LA BDD*
			//**********************************************************************************************
			$requete="UPDATE `utilisateur` SET `motdepasse` = '$hashed_pwd' WHERE email='$lemail';";
			if (!mysqli_query($connexion,$requete)) 
			{
				  echo "<br>Erreur : ".mysqli_error($connexion)."<br>";
			}
		
			
			
			mail($lemail, 'Mot de passe oublié sur le site cr bts sio', $message);
		}
		else
		{
			echo "ERREUR : email non present!";
		}
	 
		//si present = envoi email avec le mots de passe 
		//Sinon = message erreur 
	 	//on oublie pas de fermer la connexion
		mysqli_close($connexion);	
	}	

	else // Mais si elle rate
	
	//etape 1 on genere un mots de passe aleatoire 
	
	//etape 2 on modifie la bdd update avec le nouveau mots de passe haché 
	
	//etape 3 envoie du nouveau mots de passe  
	{
		echo 'Erreur'; // On affiche un message d'erreur
	}
		
}
else
{
?>
		<form method="post">
		saisir votre email : <input type="email" name="email"> <br>
		<input type="submit" value="Ok" name="bouton_email">
		</form>
<?php
}function genererMdp($longueur) { // par défaut, on affiche un mot de passe de 5 caractères
 // chaine de caractères qui sera mis dans le désordre:
 $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // 62 caractères au total
 // on mélange la chaine avec la fonction str_shuffle(), propre à PHP
 $Chaine = str_shuffle($Chaine);
 // ensuite on coupe à la longueur voulue avec la fonction substr(), propre à PHP aussi
 $Chaine = substr($Chaine,0,$longueur);
 // ensuite on retourne notre chaine aléatoire de "longueur" caractères:
 return $Chaine;
}

?>
 


