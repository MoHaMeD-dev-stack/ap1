<?php

require_once("_conf.php");
include("_conf.php");

function motDePasse($longueur)
{
    $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!+()-/";
    $Chaine = str_shuffle($Chaine);
    $Chaine = substr($Chaine, 0, $longueur);
    return $Chaine;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $login = $_POST['login'];
    $motDePasse = $_POST['motDePasse'];
    $statut = $_POST['statut'];

    if (isset($nom) && isset($prenom) && isset($email) && isset($tel) && isset($login) && isset($motDePasse)) {

        $connexion = mysqli_connect($serveur, $user, $pwd, $bdd);

        if (!$connexion) {
            echo 'Erreur de connexion à la BDD';
            exit;
        }

        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

        $requete = "INSERT INTO utilisateur
                                            (
                                                nom,
                                                prenom,
                                                tel,
                                                login,
                                                motdepasse,
                                                type,
                                                email,
                                                class_id
                                            ) VALUES (
                                                '$nom',
                                                '$prenom',
                                                '$tel',
                                                '$login',
                                                '$motDePasseHash',
                                                $statut,
                                                '$email',
                                                NULL
                                            )";
        $resultat = mysqli_query($connexion, $requete);

        if (!$resultat) {
            echo 'Erreur : la requête a échoué !';
            exit;
        }

        mysqli_close($connexion);

        header('Location: index.php');
    } else {
        echo 'Veuillez remplir tous les champs.';
    }
}

// include "_conf.php"; // Ce fichier doit définir $serveurBDD, $userBDD, $mdpBDD, $nomBDD

// if (isset($_POST['email'])) {
//     $lemail = $_POST['email'];
//     echo 'Le formulaire a été envoyé avec comme email la valeur : ' . htmlspecialchars($lemail);

//     // Connexion à la base de données
//     $connexion = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD);

//     if (!$connexion) {
//         die("Échec de la connexion à la base de données : " . mysqli_connect_error());
//     }
// } else {

//     $connexion = mysqli_connect($serveur, $user, $pwd, $bdd);

//     if (!$connexion) {
//         die("Échec de la connexion à la base de données : " . mysqli_connect_error());
//     }

//     //etape 1 on genere un mots de passe aleatoire
//     $newmdp = motDePasse(12);
//     echo "<hr>$newmdp<hr>";

//     $mdphache = md5($newmdp);
//     //etape 2 on modifie la bdd update avec le nouveau mots de passe haché
//     // $requete="UPDATE `utilisateur` SET `motdepasse` = '$mdphache' WHERE email='$lemail';";
//     if (!mysqli_query($connexion, $requete)) {
//         echo "<br>Erreur : " . mysqli_error($connexion) . "<br>";
//     }

//     //etape 3 envoie du nouveau mots de passe


//     echo "<br>email trouvé = envoi de l'email'";
//     $message = "votre nouveau mot de passe est :'$newmdp' - votre login : '$login'";
//     mail($lemail, 'votre login/mot de passe sur le site des stages', $message);


//     // Exemple : mise à jour du mot de passe pour cet utilisateur
//     $motdepasse_hash = password_hash($newmotdepasse, PASSWORD_DEFAULT);
//     $requete = "UPDATE utilisateurs SET mot_de_passe='$motdepasse_hash' WHERE email='$lemail'";

//     if (mysqli_query($connexion, $requete)) {
//         echo "<br>Mot de passe mis à jour avec succès.";
//     } else {
//         echo "<br>Erreur lors de la mise à jour : " . mysqli_error($connexion);
//     }

//     mysqli_close($connexion);
// }

?>

<form action="inscription.php" method="post">
    <fieldset style="background: #f8f0ff; border: 6px solid #9238ca;">
        <legend>Inscription</legend>
        <input type="text" name="nom" placeholder="Nom de famille" required><br /><br />
        <input type="text" name="prenom" placeholder="Prénom" required><br /><br />
        <input type="email" name="email" placeholder="Email" required><br /><br />
        <input type="text" name="tel" placeholder="Téléphone" required><br /><br />
        <input type="text" name="login" placeholder="login" required><br /><br />
        <input type="password" name="motDePasse" placeholder="mot de passe" required><br /><br />

        <label><input type="radio" name="statut" value="0" checked>Etudiant</label>
        <label><input type="radio" name="statut" value="1">Professeur</label>

        <br><br><br>

        <button name="send_con" type="submit">S'inscrire</button>
    </fieldset>
</form>
<a href="index.php"> Se connecter </a>