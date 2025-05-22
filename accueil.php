<?php

require_once("_conf.php");
include("_conf.php");

if (isset($_POST['send_con'])) {
    $login = $_POST['login'];
    $motDePasse = $_POST['mot_de_passe'];

    if ($connexion = mysqli_connect($serveur, $user, $pwd, $bdd)) {

        $requete = "SELECT * FROM utilisateur WHERE login = '" . $login . "'";
        $resultat = mysqli_query($connexion, $requete);
        $donnees = mysqli_fetch_assoc($resultat);

        if (!$donnees) {
            echo 'Erreur : identifiants invalides.';
            exit;
        }

        $motDePasseBDD = $donnees['motdepasse'];

        $verification = password_verify($motDePasse, $motDePasseBDD);

        if (!$verification) {
            echo 'Identifiants invalides !';
            exit;
        }

        session_start();

        $_SESSION['num'] = $donnees['num'];
        $_SESSION['nom'] = $donnees['nom'];
        $_SESSION['prenom'] = $donnees['prenom'];
        $_SESSION['tel'] = $donnees['tel'];
        $_SESSION['login'] = $donnees['login'];
        $_SESSION['motdepasse'] = $donnees['motdepasse'];
        $_SESSION['type'] = $donnees['type'];
        $_SESSION['email'] = $donnees['email'];
        $_SESSION['class_id'] = $donnees['class_id'];


        mysqli_close($connexion);
    } else {
        echo 'Erreur';
        exit;
    }
} else {
    echo 'Veuillez remplir tous les champs.';
    exit;
}

?>

<body>
    <div>
        <a href="deconnexion.php">Se déconnecter</a><br>
        <hr><br>
    </div>
    <?php if ($_SESSION['type'] == 0) : ?>
        <h1>Je suis étudiant !</h1>
    <?php endif ?>
    <?php if ($_SESSION['type'] == 1) : ?>
        <h1>Je suis professeur !</h1>
    <?php endif ?>
</body>