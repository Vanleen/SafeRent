<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur n'est pas connecté, on redirige vers connexion.php
// Attention, header('location:...') doit être exécutée avant tout affichage dans la page. 
if (!user_is_connected()) {
    header('location:connexion.php');
}


if ($_SESSION['membre']['civilite'] == 'f') {
    $sexe = 'femme';
} else {
    $sexe = 'homme';
}

if ($_SESSION['membre']['statut'] == 2) {
    $statut = 'vous êtes administrateur';
} else {
    $statut = 'vous êtes membre';
}

// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
// echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>

<main class="container">
    <br>
    <br>
    <div class="bg-light p-5 rounded">
        <h1 class="pb-4 border-bottom"> Profil</h1>
        <p class="lead">Bienvenue sur votre espace de gestion de profil.</p>
        <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  
        ?>
    </div>

    <div class="row">
        <div class="col-sm-6 mt-5">
            <?php
            // echo $_SESSION['membre']['pseudo']; 
            // si le statut est égal à 2 on affiche vous êtes administrateur sinon on affiche vous êtes membre
            // Pour sexe selon la valeur on affiche homme ou femme


            ?>
            <ul class="list-group">
                <li class="list-group-item bg-indigo text-white" aria-current="true">Vos informations</li>

                <li class="list-group-item li_flex"><span><i class="fas fa-user couleur_icone"></i> <b>N° : </b><?php echo $_SESSION['membre']['id_membre']; ?></span></li>

                <li class="list-group-item li_flex"><span><i class="fab fa-ethereum couleur_icone"></i> <b>Pseudo : </b><?php echo $_SESSION['membre']['pseudo']; ?></span></li>

                <li class="list-group-item li_flex"><span><i class="fas fa-signature couleur_icone"></i> <b>Nom : </b><?php echo $_SESSION['membre']['nom']; ?></span></li>

                <li class="list-group-item li_flex"><span><i class="fas fa-signature couleur_icone"></i> <b>Prénom : </b><?php echo $_SESSION['membre']['prenom']; ?></span></li>

                <li class="list-group-item li_flex"><span> <i class="far fa-envelope couleur_icone"></i> <b>Email : </b><?php echo $_SESSION['membre']['email']; ?></span></li>

                <li class="list-group-item li_flex"><span><i class="fas fa-venus-mars couleur_icone"></i> <b>Sexe : </b><?php echo $sexe; ?></span></li>

                <li class="list-group-item li_flex"><i class="fas fa-user-tag couleur_icone"></i> <span><b>Statut : </b><?php echo $statut; ?></span></li>
            </ul>
            <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        </div>
        <div class="col-sm-6 mt-5">
            <img src="<?php echo URL; ?>assets/img/profil_test.png" alt="une image de profil." class="w-100 img-thumbnail">
        </div>

        
    </div>
    <br>
    <br>
</main>

<?php
include 'inc/footer.inc.php';
?>