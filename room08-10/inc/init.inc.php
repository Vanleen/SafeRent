<?php

// Connexion à la BDD : room
$host = 'mysql:host=cl1-sql12;dbname=nsh50931';
$login = 'nsh50931';
$password = 'hmIMa9w8[';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
$pdo = new PDO($host, $login, $password, $options);


// on ouvre une session :
session_start(); // $_SESSION

// Déclaration de constante :
// Constante représentant l'url absolu racine de notre projet room
define('URL', 'https://room.vcreadev.fr/'); // à modifier lors de la mise en ligne

// chemin racine serveur pour l'enregistrement des images depuis gestion_articles.php
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']); // C:/wamp64/www (attention, il n'y a pas le / final) // info récupérée dans la superglobale donc il ne sera pas necessaire de la changer

// chemin depuis notre serveur vers le dossier de notre projet
define('PROJECT_PATH', '/home/users9/n/nsh5093/www'); // depuis notre dossier www ou htdocs, vers la racine de  notre projet. Attention de ne pas oublier le premier /

// echo ROOT_PATH . PROJECT_PATH; // C:/wamp64/www/DIW60/php/projetRoom/
// variable destinée à afficher des messages utilisateur. Cette variable est appelée en dessous du titre de nos page. Sur toutes nos pages.
$msg = '';