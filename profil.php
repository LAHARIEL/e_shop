<?php require_once "inc/init.php"; 


if(!estConnecte()){
    header('location:connexion.php');// on redirige le membre NON connecté vers la page connexion.php
    exit;
}


require_once("inc/header.php"); 
?>

<h1>Profil</h1>
<h2>Bonjour <?= $_SESSION['membre']['prenom'] .' '. $_SESSION['membre']['nom'] ?></h2><!--On accède aux informations stockées en session -->

<h3>Vos informations</h3>

<ul>
    <li>Email : <?= $_SESSION['membre']['email']?></li>
    <li>Adresse : <?= $_SESSION['membre']['adresse']?></li>
    <li>Code postal : <?= $_SESSION['membre']['code_postal']?></li>
    <li>Ville : <?= $_SESSION['membre']['ville']?></li>
</ul>

<?php require_once "inc/footer.php";