<?php 
require_once "../inc/init.php";

if(!estConnecteAdmin()){// on vérifie que le membre est bien admin sinon on redirige vers la page de connexion
    header('location:../connexion.php');
    exit;
}

//Afficher la liste des produits dans une table avec 2 boutons => Modifier et Supprimer

'<h1>Gestion de la boutique</h1>';

// formule pour supprimer un produit
if(isset($_GET['id_produit'])){// l'info de id_produit est récupérée suite au clic sur le bouton "supprimer" qui est positionné sur cette même page
    $resultat = executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit'=> $_GET['id_produit']));

    if($resultat->rowCount() == 1){// on entre dans cette condition si la requête s'est bien passée ==> il y a bien 1 donnée stockée dans la variable $resultat.  
        $contenu .= '<div class="alert alert-success">Le produit a bien été supprimé</div>';
    }else{// on entre dans cette condition si la requête ne s'est PAS bien passée ==> il y a eu un soucis, il faut réviser le code et corriger le pb
        $contenu .= '<div class="alert alert-danger">Le produit n\'a pas été supprimé</div>';
    }
}

    
    $resultat = executeRequete("SELECT * FROM produit");//on sélectionne tous les produits
     
    $contenu .= '<h2>Affichage des Produits</h2>';
    $contenu .= 'Nombre de produit(s) dans la boutique : ' . $resultat->rowCount();
   
    $contenu .= '<a class="btn btn-primary mt-2 mb-2" href="formulaire_produit.php">Ajouter un produit</a>';

    $contenu .= '<table class="table">';
    $contenu .= '<tr>';
    $contenu .= '<th>ID</th>';
    $contenu .= '<th>Référence</th>';
    $contenu .= '<th>Catégorie</th>';
    $contenu .= '<th>Titre</th>';
    $contenu .= '<th>Description</th>';
    $contenu .= '<th>Couleur</th>';
    $contenu .= '<th>Taille</th>';
    $contenu .= '<th>Public</th>';
    $contenu .= '<th>Photo</th>';
    $contenu .= '<th>Prix</th>';
    $contenu .= '<th>Stock</th>';
    $contenu .= '<th>Action</th>'; // colonne pour les liens "modifier et supprimer"
    $contenu .= '</tr>';

// debug($resultat);

while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {// puisque $produit est un tableau, on le parcours avec une foreach
    $contenu .= '<tr>';//on crée 1 ligne de table par produit
    foreach ($produit as $indice => $information) {//$information parcours les valeurs de $produit
        if ($indice == 'photo') {// si l'indice se trouve sur le champs "photo", on affiche une balise img dans lequel on pourra mettre le chemin stocke en bdd
            $contenu .= '<td><img style="width:90px" src="../' . $information . '"</td>';// $information contient le chemin relatif de la photo vers le dossier "photo/" qui se trouve dans le dossier parent. on concatène donc "../".
        } else {// sinon on affiche les autrs valeurs dans une <td> seul
            $contenu .= '<td>' . $information . '</td>';
        }
    }

    $contenu .= '<td>   <a href="formulaire_produit.php?id_produit='.$produit['id_produit'].'" class="btn btn-primary">Modifier</a>
    <a href="?id_produit='.$produit['id_produit'].'" class="btn btn-danger">Supprimer</a>
</td>';

// a gérer la suppression du produit => on envoie en GET l'id de mon produit
// pour modifier il faut faire un renvoie vers la page formulaire_produit

$contenu .= '</tr>';
}

$contenu .= '</table>';

require_once "../inc/header.php"; 



// <!-- insertion dans la page des messages d'erreur lors du controle des éléments du formulaire-->
// <!-- <?= $contenu; ? > -->

echo $contenu;

require_once "../inc/footer.php"; 