<?php
require_once "inc/init.php";

$message = ''; // pour afficher le message de déconnexion

// Déconexion du membre

if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') { //on récupère les données activées par le lien sur "Déconnection" dans le barre de navigation. on entre dans la condition s'il y a qq chose dans 'action' et que c'est "deconnexion"
    unset($_SESSION['membre']); // la session de l'internaute est stoppée => il est déconnecté
    $message = '<div class="alert alert-info">Vous êtes déconnecté</div>';
}

if (estConnecte()) { // on vérifie que le membre n'est pas déjà connecté. si'il est connecté on le redirige vers la page de profil ==> évite de passer outre en modifiant le lien url directement vers la page connexion car on sera automatiquement redirigé vers la page profil.php
    header('location:profil.php');
    exit;
}

// traitement

if (!empty($_POST)) { // on teste si le formulaire a été envoyé

    // on controle les champs de formulaire

    if (empty($_POST['pseudo']) || empty($_POST['mdp'])) { //si le pseudo ou le mdp est vide
        $contenu .= '<div class="alert alert-danger">Les identifiants sont obligatoires !</div>';
    }

    // si les champs sont remplis, on vérifie le pseudo puis le mot de passe en bdd
    if (empty($contenu)) { // si la variable est vide, c'est qu'il n'y a pas de message d'erreurs
        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));

        if ($resultat->rowCount() == 1) { // s'il y a une ligne de résultat, c'est que le pseudo est en BDD : on peut alors vérifier le mdp
            $membre = $resultat->fetch(PDO::FETCH_ASSOC); // on fetch l'objet $resulat pour en extraire les données, sans boucle car le pseudo est unique en BDD
            // debug($membre);
            $mdp_Hash = $membre['mdp'];// variable qui stock mon mdp après le traitement de "hash"
            // debug($mdp_Hash);

            if (password_verify($_POST['mdp'], $mdp_Hash)) { // password_verify() retourne true si le hash de la bdd correspond au mdp du formulaire
                // true, on peut connecter le membre avec une session :

                $_SESSION['membre'] = $membre; // pour connecter le membre on crée une session appelée 'membre' avec toutes les infos du memebre qui viennent de la BDD
                header('location:profil.php'); // les identifiants étant corrects on redirige l'internaute vers la page profil.php
                exit; // et on quitte le script
            } else { // sinon c'est que le mdp est erroné
                $contenu .= '<div class="alert alert-danger">Erreur sur les identifiants</div>';
            }
        } else { // sinon c'est que le pseudo n'est pas en bdd
            $contenu .= '<div class="alert alert-danger">Erreur sur les identifiants</div>';
        }
    }
}

require_once "inc/header.php";
?>

<h1>Connexion</h1>

<!-- insertion dans la page des messages d'erreur lors du controle des éléments du formulaire-->
<?php
echo $message;
echo $contenu;
?>

<form action="" method="POST">
    <div><label for="pseudo">Pseudo</label></div>
    <div><input type="text" id="pseudo" name="pseudo" maxlength="20" placeholder="votre pseudo"></div>
    <!-- pattern="[a-zA-Z0-9-_.]{1,20}" title="caractères acceptés : a-zA-Z0-9-_." required="required" -->

    <div><label for="mdp">Mot de passe</label></div>
    <div><input type="password" id="mdp" name="mdp"></div>
    <!-- required="required" -->

    <div><input type="submit" value="Se connecter" class="btn btn-info"></div>

</form>


<?php require_once "inc/footer.php";
