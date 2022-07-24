<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Boutique de Lauriane</title>
</head>

<body>
    <header class=" bg-dark p-2">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Ma boutique</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- gérer les acces au menu pour l'admin pour les onglet dans le dossier "admin" -->
                        <?php
                        if (estConnecte()) { ?>
                            <!-- si l'internaute (non admin) est connecté, il verra les boutons de menu "Profil" et "Déconnexion" -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_root; ?>profil.php">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_root; ?>connexion.php?action=deconnexion">Déconnexion</a>
                            </li>
                        <?php } else { ?>
                            <!-- si l'internaute n'est pas connecté, il verra les boutons de menu "Inscription" et "Connexion" -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_root; ?>inscription.php">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_root; ?>connexion.php">Connexion</a>
                            </li>
                        <?php } ?>
                        <!-- Menu qui s'affiche peu importe si l'internaute est connecté ou pas -->
                        <!-- Ces 2 pages n'ont pas encore été codées -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_root; ?>detail_produit.php">Produits</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_root; ?>statut.php">Statut</a>
                        </li>
                        <?php
                        if (estConnecteAdmin()) { ?>
                            <!-- si l'internaute est connecté ET admin, il verra les boutons de menu "Formulaire produit", "Gestion boutique" et "Gestion membre" et aussi "Profil" et "Déconnexion" . on ne fait pas de lien direct vers le formulaire produit car son accès a été géré par un bouton sur la page gestion_boutique -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_root; ?>admin/gestion_boutique.php">Gestion boutique</a>
                            </li>
                            <!-- Cette page n'e pas encore été codée -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_root; ?>admin/gestion_membre.php">Gestion membre</a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container">
        <section class="p-2" style="min-height : 800px">