<?php

// Connection à la bdd en utilisant PDO
$pdo = new PDO('mysql:host=localhost; dbname=site', 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

//lancement session
session_start(); // Crée un fichier de session sur le server dans lequel on stockera des données : celle du membre ou de son panier. Si la session existe déjà, on y accède directement à l'aide de l'identifiant reçu dans un cookie depuis le navigateur de l'internaute


//definition d'une constante pour définir la racine du site =>  ça sert à modifier le chemin vers le fichier source sur tous les liens en même temps (avec une ligne de cde) ==> utile pour la mise en ligne du site par ex car le dépot distant n'aura plus le meme chemain que notre stockage local
define('site_root', '/phpp/site/');// ici on indique le dossier dans lequel se trouve le site à partir de "localhost". S'il n'est dans aucun dossier, on met un "/" seul. Permet de créer des chemins absolus à partir de "localhost". 

// variable qu'on utilisera pour afficher sur la page des messages de retour d'erreur pour la saisie du formulaire par ex
$contenu = '';//Initialisation d'une variable pour afficher du contenu HTML

//inclusion du fichier functions.php
require_once 'functions.php';
