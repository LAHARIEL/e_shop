<?php require_once "inc/init.php";

if(estConnecte()){// on vérifie que le membre n'est pas déjà connecté. si'il est connecté on le redirige vers la page de profil ==> évite de passer outre en modifiant le lien url directement vers la page inscription
    header('location:profil.php');
    exit;
}

// debug($_POST);

if (!empty($_POST)) { //si ce qui est contenu dans la variable "post" n'est pas vide (donc si le formulaire a été envoyé) on entre dans le traitement ci-dessous

    // on controle les champs de formulaire

    if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) { // si le champs "pseudo" n'exsite pas OU que sa longeur est inférieure à 4 OU que sa longueur est supérieur à 20 (car limite de notre BDD), alors on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir entre 4 et 20 caractères</div>';
    }

    if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20) {
        $contenu .= '<div class="alert alert-danger">Le mot de passe doit contenir entre 4 et 20 caractères</div>';
    }

    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {
        $contenu .= '<div class="alert alert-danger">Le nom doit contenir entre 2 et 20 caractères</div>';
    }

    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {
        $contenu .= '<div class="alert alert-danger">Le prenom doit contenir entre 2 et 20 caractères</div>';
    }

    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $contenu .= '<div class="alert alert-danger">L\'email n\'est pas valide</div>';
    }


    if (!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f')) {
        $contenu .= '<div class="alert alert-danger">La civilite n\'est pas valide</div> ';
    }

    if (!isset($_POST['ville']) || strlen($_POST['ville']) < 1 || strlen($_POST['ville']) > 20) {
        $contenu .= '<div class="alert alert-danger">La ville n\'est pas valide</div>';
    }

    // controle des données de ce champs du formulaire avec un regex fonction preg_match
    if (!isset($_POST['code_postal']) || !preg_match('#^[0-9]{5}$#', $_POST['code_postal'])) { // regex #^ début de chaine fin de chaine #$, on accepte un intervalle de chifffre allant de 0 à 9 et un nombre de chiffre global de 5
        $contenu .= '<div class="alert alert-danger">La ville n\'est pas valide</div>';
    }

    if (!isset($_POST['adresse']) || strlen($_POST['adresse']) < 4 || strlen($_POST['adresse']) > 50) {
        $contenu .= '<div class="alert alert-danger">L\'adresse doit contenir entre 4 et 50 caractères</div>';
    }


    if (empty($contenu)) {

        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));
        // debug($resultat);

        // contrôle si pseudo n'existe pas déjà en bdd 
        if ($resultat->rowCount() > 0) {// s'il y a 1 ou plusieurs lignes dans l'objet $resultat, c'est que le pseudo est déjà en BDD
            $contenu .= '<div>Le pseudo existe déjà. Veuillez en choisir un autre</div>';
        } else {

            // pseudo est disponible, on insère en BDD

            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);// cette fonction retourne la clé de hachage de notre mot de passe selon l'algorithme "bcrypt" par défaut. Il faudra sur la page de connexion comparer le hash de la bdd avec celui fourni lors de la connexion avec la fonction password_verify
            // indiquer l'algorithme PASSWORD_DEFAULT permet de bénéficier du "meilleur" algo existant. En 2022 c'est "bcrypt" donc cela équivaut à indiquer PASSWORD_BCRYPT
        
            $succes = executeRequete(
                "INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, :statut)",
                array(
                    ':pseudo' => $_POST['pseudo'],
                    ':mdp' => $mdp,// on prend le mot de passe hashé
                    ':nom' => $_POST['nom'],
                    ':prenom' => $_POST['prenom'],
                    ':email' => $_POST['email'],
                    ':civilite' => $_POST['civilite'],
                    ':ville' => $_POST['ville'],
                    ':code_postal' => $_POST['code_postal'],
                    ':adresse' => $_POST['adresse'],
                    ':statut' => 0 // 0 pour les membres classiques (non admin)
                )
            );
            if($succes){
                $contenu .= '<div class="alert alert-success">Vous êtes inscrits à notre site web. Pour vous connecter <a href="connexion.php">cliquez ici</a></div>';
            }else{
                $contenu .= '<div class="alert alert-danger">Une erreur est survenue ...</div>';
            }
        }
    }
}


require_once "inc/header.php";
?>

<h1>Inscription</h1>

<!-- insertion dans la page des messages d'erreur lors du controle des éléments du formulaire-->
<?= $contenu; ?>

<form action="" method="post">
    <label for="pseudo">Pseudo</label><br>
    <input type="text" id="pseudo" name="pseudo" placeholder="votre pseudo"><br><br>
    <!-- maxlength="20" pattern="[a-zA-Z0-9-_.]{1,20}" title="caractères acceptés : a-zA-Z0-9-_." required="required" -->


    <label for="mdp">Mot de passe</label><br>
    <input type="password" id="mdp" name="mdp"><br><br>
    <!-- required="required" -->

    <label for="nom">Nom</label><br>
    <input type="text" id="nom" name="nom" placeholder="votre nom"><br><br>

    <label for="prenom">Prénom</label><br>
    <input type="text" id="prenom" name="prenom" placeholder="votre prénom"><br><br>

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" placeholder="exemple@gmail.com"><br><br>

    <label for="civilite">Civilité</label><br>
    <input name="civilite" value="m" type="radio">Homme
    <input name="civilite" value="f" checked="" type="radio">Femme<br><br>

    <label for="ville">Ville</label><br>
    <input type="text" id="ville" name="ville" placeholder="votre ville"><br><br>
    <!-- pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-zA-Z0-9-_." -->

    <label for="code_postal">Code Postal</label><br>
    <input type="text" id="code_postal" name="code_postal" placeholder="code postal"><br><br>
    <!-- pattern="[0-9]{5}" title="5 chiffres requis : 0-9" -->

    <label for="adresse">Adresse</label><br>
    <textarea id="adresse" name="adresse" placeholder="votre adresse" cols="30" rows="10"></textarea><br><br>
    <!-- pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés :  a-zA-Z0-9-_." -->

    <input type="submit" name="inscription" value="S'inscrire" class="btn btn-info">
</form>

<?php require_once "inc/footer.php"; 