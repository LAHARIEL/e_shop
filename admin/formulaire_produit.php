<?php 
require_once "../inc/init.php";// on remonte vers le dossier parent avec ../

//Controle si estAdmin sinon redirection vers le formulaire d'authentification
if(!estConnecteAdmin()){//on vérifie que le membre est bien admin, sinon on le redirige vers la page de connexion :
    header('location:../connexion.php');
    exit;
}

//traitement PHP du formulaire HTML pour l'insertion de nouveau produits mais aussi pour la modification de produits 
if(!empty($_POST)){// si le formulaire a été envoyé

// ici il faudrait mettre les conditions de contrôle du formulaire

    $photo_bdd = "";//initialisation de la variable $photo_bdd à vide pour prévoir le cas d'ajout de produit sans joindre une photo


    if(isset($_POST['photo_actuelle'])){// si existe "photo_actuelle" dans $_POST, c'est que je suis en train de modifier le produit : je veux donc remettre le chemin de la photo en BDD
        $photo_bdd=$_POST['photo_actuelle']; // alors on affecte le chemin de la photo actuelle à la variable $photo_bdd qui est insérée en BDD
    }

// $_FILES est une superglobale générée par le type="file" du champ "photo" du formulaire. Le premier indice de $_FILES correspond au "name" de cet input. A cet indice on trouve toujours un sous-tableau avec l'indice "name" qui contient le nom du fichier en cours d'upload, l'indice "type" qui contient le type du fichier (ici image), l'indice "size" qui contient sa taille en octets.
if(!empty($_FILES['photo']['name'])){
    // $_FILES est normé. la 2e paire de crochet permet de récupérer le nom de la photo (=du fichier qui est loadé)
    // si  le nom de la photo (donc du fichier) n'est pas vide, c'est qu'un fichier est en cours d'upload


$nom_fichier = $_FILES['photo']['name'];//on attribut un nom à la photo qui va être joint
$photo_bdd = 'photo/'.$nom_fichier;// cette variable contient le chemin relatif de l'image que l'on insère en BDD (elle est dans le dossier photo/ et s'appelle $nom_fichier)

copy($_FILES['photo']['tmp_name'], '../'.$photo_bdd);// on copie le fichier photo temporaire qui est dans $_FILES['photo']['tmp_name'] vers le répertoire dont le chemin est "../photo/nom_fichier".
}


    //insertion du produit en BDD
    // étape 1 dans la création des fonctionnalités de la boutique => on teste la création . Donc on utilise une requete INSERT INTO  et on teste que ça marche !
    // étape 2 dans la création des fonctionnalités de la boutique => on veut pouvoir modifier les données de notre produit crée en BDD. Pour ça on va mettre à jour le code de notre requête. INSERT INTO devient donc REPLACE INTO. il ne faut pas oublier à ce moment là d'ajouter dans la () les champs id_produit et l'association avec :id_produit. penser aussi à ajouter l'association dans l'array
    // la récupération de l'info $_POST['id_produit'] est gérée par un ajout de code dans un champs du formulaire, et qui sera caché à l'utilisateur. ce champs sera renseigné grâce à une nouvelle formule conditionnelle (à placer avant l'insertion du header et le formulaire HTML). cette formule récupère le $_GET['id_produit'] (qui est rempli au click sur le bouton "modifier" qui est sur la page gestion_boutique) et le place $produit['id_produit'] que l'input caché reçoit en donnée "post" 
    // étape 3 , on fait préremplir le formulaire de modification avec les informations déjà présentes dans la BDD pour faciliter l'expérience utilisateur. pour cela on ajoute des attributs dans le formulaire HTML

    // REPLACE fait un INSERT quand un l'ID n'existe PAS en BDD (valeur 0)
    // REPLACE fait un UPDATE quand l'ID existe en BDD
$succes = executeRequete("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)", // ajout de id_produit et :id_produit pour utilisation de la requete REPLACE INTO
array(
    ':id_produit' => $_POST['id_produit'], // ajout de la ligne pour la requete REPLACE INTO
    ':reference' => $_POST['reference'], 
    ':categorie' => $_POST['categorie'], 
    ':titre' => $_POST['titre'],
    ':description' => $_POST['description'], 
    ':couleur' => $_POST['couleur'], 
    ':taille' => $_POST['taille'], 
    ':public' => $_POST['public'], 
    ':photo' => $photo_bdd, // chemin de la photo uploadée qui est vide par défaut
    ':prix' =>$_POST['prix'],
    ':stock' => $_POST['stock']
));
if($succes){// si on a reçu un objet PDOStatement c'est que la requête a marché
    $contenu .= '<div class="alert alert-success">Le produit a été ajouté</div>';
}else{// sinon on a reçu false, la requête n'a pas marché
    $contenu .= '<div class="alert alert-danger">Une erreur est survenue ...</div>';
}
}

// formule à ajouter quand on modifie la requete de INSERT INTO vers REPLACE INTO
if (isset($_GET['id_produit'])) { // si 'id_produit' est dans l'URL, c'est qu'on a demandé la modification d'un produit
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
    $produit = $resultat->fetch(PDO::FETCH_ASSOC); //$produit est un tableau associatif dont on va mettre les valeurs dans les champs de formulaire
//     debug($produit);
}

require_once "../inc/header.php"; 
?>

<h1>Formulaire des produits</h1>
<!-- insertion dans la page des messages d'erreur lors du controle des éléments du formulaire-->
<?= $contenu; ?>

<!-- Formulaire HTML qui servira non seulement pour l'insertion de nouveau produits mais aussi pour la modification de produits et le traitement PHP permettant d'insérer ou modifier. -->
<div><form action="" method="POST" enctype="multipart/form-data"><!-- l'attribut enctype="multipart/form-data" spécifique que le formulaire envoie des données binaires (fichier) et du texte (champs du formulaire) : permet d'uploader un fichier (ici une photo). -->

<!-- insertion d'un nouveau input qui sera caché à l'utilisateur, pour récupérer la données de l'id_produit -->
<input type="hidden" name="id_produit" value="<?php echo $produit['id_produit'] ?? 0; ?>">
    <!-- le champs caché id_produit est nécessaire pour la MODIFICATION d'un produit (UPDATE) car on a besoin de récupérer l'ID du produit modifié pour la requête SQL "REPLACE INTO" . Quand on crée un produit nouveau (INSERT) on met une valeur par défaut à 0 pour que "REPLACE INTO" se comporte comme un INSERT -->

<div><label for="reference">Référence</label></div>
<div><input type="text" name="reference" id="reference" value="<?php echo $produit['reference'] ?? ''; ?>"></div>
<!-- au début on test seulement la création. l'attribut value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans l'input l'attribut value -->

<div><label for="categorie">Catégorie</label></div>
<div><input type="text" name="categorie" id="categorie" value="<?php echo $produit['categorie'] ?? ''; ?>"></div>
<!-- au début on test seulement la création. l'attribut value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans l'input l'attribut value -->

<div><label for="titre">Titre</label></div>
<div><input type="text" name="titre" id="titre" value="<?php echo $produit['titre'] ?? ''; ?>"></div>
<!-- au début on test seulement la création. l'attribut value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans l'input l'attribut value -->

<div><label for="description">Description</label></div>
    <div><textarea name="description" id="description" cols="30" rows="10"><?php echo $produit['description'] ?? ''; ?></textarea></div>
<!-- au début on test seulement la création. l'ajout de la formule dans l'afficage de la balise textarea n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute la formule dans la zone d'affichage de la balise textarea -->

<div><label for="couleur">Couleur</label></div>
<div><input type="text" name="couleur" id="couleur" value="<?php echo $produit['couleur'] ?? ''; ?>"></div>
<!-- au début on test seulement la création. l'attribut value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans l'input l'attribut value -->

<div><label for="taille">Taille</label></div>
    <div><select name="taille" id="taille">
            <option value="S">S</option>
            <option value="M" <?php if (isset($produit['taille']) && $produit['taille'] == 'M') echo 'selected'; ?>>M</option>
            <option value="L" <?php if (isset($produit['taille']) && $produit['taille'] == 'L') echo 'selected'; ?>>L</option>
            <option value="XL" <?php if (isset($produit['taille']) && $produit['taille'] == 'XL') echo 'selected'; ?>>XL</option>
        </select></div>
        <!-- au début on test seulement la création. la formule pour value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans value la formule qui vient préselectionner la taille selon ce qui en BDD -->

    <div><label for="public">Public</label></div>
    <div><input type="radio" name="public" value="f" checked>Féminin</div>
    <div><input type="radio" name="public" value="m" <?php if (isset($produit['public']) && $produit['public'] == 'm') echo 'checked'; ?>>Masculin</div>
    <div><input type="radio" name="public" value="mixte" <?php if (isset($produit['public']) && $produit['public'] == 'mixte') echo 'checked'; ?>>Mixte</div><!-- attention le champ public est un ENUM en BDD qui n'attend que les valeurs "m", "f" ou "mixte" -->
            <!-- au début on test seulement la création. la formule pour value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans value la formule qui vient préselectionner la taille selon ce qui en BDD -->

<div><label for="photo">Photo</label></div>
<div><input type="file" name="photo"></div>
<!-- l'id n'est pas nécessaire ici pour le type "file" -->
<!-- le type="file" permet de remplir la superglobale $_FILES. Le name="photo" correspond à l'indice de $_FILES['photo']. Pour uploader 1 fichier, il ne faut pas oublier l'attribut enctype="multipart/form-data" sur la balise <form>. -->

<?php
    if (isset($produit['photo'])) { //si existe $produit['photo'] c'est que nous sommes en train de modifier le produit
        echo '<div>Photo actuelle du produit</div>';
        echo '<div><img style="width:90px;" src="../' . $produit['photo'] . '"></div>'; // on affiche la photo actuelle dont le chemin est dans le champs "photo" de la BDD donc dans $produit
        echo '<input type="hidden" name="photo_actuelle" value="' . $produit['photo'] . '">'; // on crée ce champs caché pour remttre le chemin de la photo actuelle dans le formulaire, donc dans $_POST à l'indice'photo_actuelle'. ainsi on ré-insère ce chemain en BDD lors de la modification
    }
    ?>

<div><label for="prix">Prix</label></div>
<div><input type="text" name="prix" id="prix" value="<?php echo $produit['prix'] ?? ''; ?>"></div>
<!-- au début on test seulement la création. l'attribut value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans l'input l'attribut value -->

<div><label for="stock">Stock</label></div>
<div><input type="text" name="stock" id="stock" value="<?php echo $produit['stock'] ?? ''; ?>"></div>
<!-- au début on test seulement la création. l'attribut value n'est pas utile pour cela -->
<!-- ensuite on veut permettre la modification du produit, et le préremplissage du formulaire avec les données déjà présentes en BDD. pour cela on ajoute dans l'input l'attribut value -->

<div><input type="submit" value="Enregistrement du produit" class="btn btn-info"></div>

</form>
</div>
<?php require_once "../inc/footer.php"; 
