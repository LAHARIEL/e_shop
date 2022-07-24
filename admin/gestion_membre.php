<?php 
require_once "../inc/init.php";

if(!estConnecteAdmin()){
    header('location:../connexion.php');
    exit;
}

// afficher liste des membres ? 
// permettre la modification de leur statut?

require_once "../inc/header.php"; 
?>

<h1>Gestion des membres</h1>
<!-- insertion dans la page des messages d'erreur lors du controle des éléments du formulaire-->
<?= $contenu; ?>

<?php require_once "../inc/footer.php"; 
