<?php
// Fonction permettant de savoir si l'utilisateur est connecté : true / false
function user_is_connected() {
    if( !empty($_SESSION['membre']) ) {
        return true;
    } else {
        return false;
    }
}

// Fonction permettant de savoir si un utilisateur est connecté et en plus si son statut est admin
function user_is_admin() {
    if(user_is_connected() && $_SESSION['membre']['statut'] == 2) {
        return true;
    }
    return false;
}

// Fonction pour mettre la classe active sur les liens du menu
// echo class_active('/profil.php');
function class_active($url) {
    // strrchr(permet de découper une chaine depuis la fin et de remonter jusqu'au deuxième argument)
    // exemple strrchr('DIW60/php/eshop/profil.php', '/'); on récupère /profil.php
    $page = strrchr($_SERVER['PHP_SELF'], '/');
    // on test si $url correspond à la page récupérée
    if($page == $url) {
        return ' active ';
    }
}

// Fonction pour le mdp avec une lettre maj, une minuscule, un caractère spécial et un chiffre
function valid_pass($password)
{
   $r1 = '/[A-Z]/';  //Uppercase
   $r2 = '/[a-z]/';  //lowercase
   $r3 = '/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
   $r4 = '/[0-9]/';  //numbers

   if (preg_match_all($r1, $password, $o) < 1) return FALSE;

   if (preg_match_all($r2, $password, $o) < 1) return FALSE;

   if (preg_match_all($r3, $password, $o) < 1) return FALSE;

   if (preg_match_all($r4, $password, $o) < 1) return FALSE;

   if (mb_strlen($password, 'utf-8') < 8) return FALSE;

   return TRUE;
}