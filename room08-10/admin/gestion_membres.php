<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur n'est pas admin, on le redirige vers connexion.php
if( !user_is_admin() ) {
    header('location:../connexion.php');
    exit(); // bloque l'exécution du code à la suite de cette ligne.
}

// Comment supprimer une membre
if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_membre']) ) {
    $suppression = $pdo->prepare("DELETE FROM membre WHERE id_membre = :id_membre");
    $suppression->bindParam(':id_membre', $_GET['id_membre'], PDO::PARAM_STR);
    $suppression->execute();
}

$id_membre = ''; // pour la modif


$pseudo = '';
$nom = '';
$prenom = '';
$email = '';
$civilite = '';
$statut = '';

// Si le formulaire a été validé, on fait un isset de tous les champs

if( isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['civilite']) && isset($_POST['statut']) ) {

    $pseudo = trim($_POST['pseudo']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $civilite = trim($_POST['civilite']);
    $statut = trim($_POST['statut']);

    // Pour la modif, récupération de l'id
    if( !empty($_POST['id_membre']) ) {
        $id_membre = trim($_POST['id_membre']);
    }

    // Déclaration d'une variable nous permettant de savoir s'il y a eu des erreurs dans nos contrôles
    $erreur = false;


    // on enregistre en BDD
    if($erreur == false) {

        // si l'id_membre n'est pas vide, on est dans une modif :
            if (!empty($id_membre)) {
                $enregistrement = $pdo->prepare("UPDATE membre SET pseudo = :pseudo, nom  = :nom, prenom = :prenom, email = :email, civilite = :civilite, statut = :statut  WHERE id_membre = :id_membre");
                $enregistrement->bindParam(':id_membre', $id_membre, PDO::PARAM_STR);
            } else {
                $enregistrement = $pdo->prepare("INSERT INTO membre (pseudo, nom, prenom, email, civilite, statut) VALUES (:pseudo, :nom, :prenom, :email, :civilite, :statut)");
            }
    
            $enregistrement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $enregistrement->bindParam(':nom', $nom, PDO::PARAM_STR);
            $enregistrement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $enregistrement->bindParam(':email', $email, PDO::PARAM_STR);
            $enregistrement->bindParam(':civilite', $civilite, PDO::PARAM_STR);
            $enregistrement->bindParam(':statut', $statut, PDO::PARAM_STR);
            $enregistrement->execute();
        }


} // Fin des isset

if (isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_membre'])) {
    // pour la modification, on lance une requete en bdd et on affecte les infos dans les variables présentent dans les value de nos champs du form
    $recup_infos = $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
    $recup_infos->bindParam(':id_membre', $_GET['id_membre'], PDO::PARAM_STR);
    $recup_infos->execute();

    $infos_membre = $recup_infos->fetch(PDO::FETCH_ASSOC);

    $id_membre = $infos_membre['id_membre'];
    $pseudo = $infos_membre['pseudo'];
    $nom = $infos_membre['nom'];
    $prenom = $infos_membre['prenom'];
    $email = $infos_membre['email'];
    $civilite = $infos_membre['civilite'];
    $statut = $infos_membre['statut'];
}

// Récupération des articles en BDD
$liste_membres = $pdo->query("SELECT * FROM membre ORDER BY pseudo");

// Les affichages des inclusions dans la page commencent depuis la ligne suivante :
include '../inc/header.inc.php';
include '../inc/nav.inc.php';
?>

<!-- Bannière de la page -->
<main class="container">
    <div class="p-5 rounded">
        <h1 class="pb-4 border-bottom">Gestion des membres</h1>
        <p class="lead">Bienvenue sur votre espace de gestion des membres, cher Administrateur.</p>
        <?php echo $msg . '<hr>'; // Message d'erreur utilisateur qui s'affiche en cas d'erreur sur le pseudo ou autre ?>
        <div>
            <img class="illustration" src="../assets/img/illustration2.png" alt="Une image de la gestion membre.">
        </div>
    </div>

    <?php if (isset($_GET['action']) && $_GET['action'] == 'modifier') { ?>

    <div class="row">
            <div class="col-12 mt-5">
            
                <form  method="post" action="gestion_membres.php" class="border p-3" enctype="multipart/form-data">

                    <input type="hidden" name="id_membre" value="<?php echo $id_membre ?>">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-6 mb-2">
                                <label for="pseudo" class="form-label">Pseudo</label>
                                <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="categorie" class="form-label">Civilité</label>
                                <select class="form-control" id="civilite" name="civilite">
                                    <option value="f" <?php if($civilite == 'f') { echo 'selected'; } ?> >Femme</option>
                                    <option value="m" <?php if($civilite == 'm') { echo 'selected'; } ?> >Homme</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="capacite" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>">
                            </div>

                            <div class="mb-4">
                                <label for="nom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>">
                            </div>
                        

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">                            
                            </div>

                            <div class="mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <input type="text" class="form-control" id="statut" name="statut" value="<?php echo $statut; ?>">                            
                            </div>
                    
                            <div class="mb-3">                                
                                <input type="submit" class="btn btn-outline-white text-white w-100" id="enregistrement" name="enregistrement" value="Enregistrement">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php } ?>

        <!-- Affichage du tableau des articles -->
        <div class="row">
            <div class="col-12 mt-5">
                <table class="table table-bordered">
                    <tr class="bg-light text-secondary">
                        <th>Id Membre</th>
                        <th>Pseudo</th>
                        <th>Civilité</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    <?php 
                        while($ligne = $liste_membres->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $ligne['id_membre'] . '</td>';
                            echo '<td>' . $ligne['pseudo'] . '</td>';
                            echo '<td>' . $ligne['civilite'] . '</td>';
                            echo '<td>' . $ligne['nom'] . '</td>';
                            echo '<td>' . $ligne['prenom'] . '</td>';
                            echo '<td>' . $ligne['email'] . '</td>';
                            echo '<td>' . $ligne['statut'] . '</td>';

                            echo '<td class="text-center"><a href="?action=modifier&id_membre=' . $ligne['id_membre'] . '" class="btn-warning text-white"><i class="fas fa-edit"></i></a></td>';

                            echo '<td class="text-center"><a href="?action=supprimer&id_membre=' . $ligne['id_membre'] . '" class="btn-danger confirm_delete" ><i class="far fa-trash-alt"></i></a></td>';

                            echo '</tr>';
                        }
                    ?>

                </table>
            </div>
        </div>
    </main>



<?php 
// Inclusion du footer
include '../inc/footer.inc.php';