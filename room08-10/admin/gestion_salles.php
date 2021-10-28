<?php
include '../inc/init.inc.php';
include '../inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur n'est pas admin, on le redirige vers connexion.php
if (!user_is_admin()) {
    header('location:../index.php');
    exit(); // bloque l'exécution du code à la suite de cette ligne.
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// SUPPRESSION SALLE
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_salle'])) {
    $suppression = $pdo->prepare("DELETE FROM salle WHERE id_salle = :id_salle");
    $suppression->bindParam(':id_salle', $_GET['id_salle'], PDO::PARAM_STR);
    $suppression->execute();
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// ENREGISTREMENT & MODIFICATION SALLE 
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
$id_salle = ''; // pour la modif
$ancienne_photo = ''; // pour la modif

$titre = '';
$description = '';
// $photo = '';
$capacite = '';
$categorie = '';
$pays = '';
$ville = '';
$adresse = '';
$cp = '';


// si le formulaire a été validé : isset de tous les champs sauf pour la Photo !
// Les pièces jointes d'un formulaire (input type="file") seront dans la superglobale $_FILES
// Ne pas oublier cet attribut sur la balisse form : enctype="multipart/form-data" sinon on ne récupère pas les pièces jointes.
if (isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['capacite']) && isset($_POST['categorie']) && isset($_POST['pays']) && isset($_POST['ville']) && isset($_POST['adresse']) && isset($_POST['cp'])) {

    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);


    // $photo = $_POST['photo']; //photo géré dans $_FILES

// var_dump($_FILES);

    $capacite = trim($_POST['capacite']);
    $categorie = trim($_POST['categorie']);
    $pays = trim($_POST['pays']);
    $ville = trim($_POST['ville']);
    $adresse = trim($_POST['adresse']);
    $cp = trim($_POST['cp']);

    // Pour la modif, récupération de l'id et de la photo
    if (!empty($_POST['id_salle'])) {
        $id_salle = trim($_POST['id_salle']);
    }
    if (!empty($_POST['ancienne_photo'])) {
        $photo = trim($_POST['ancienne_photo']);
    }

    // Déclaration d'une variable nous permettant de savoir s'il y a eu des erreurs dans nos contrôles
    $erreur = false;


    // Si le stock est vide on affecte à 0 pour ne pas avoir d'erreur sql + message utilisateur, on ne bloque pas l'enregistrement
    if (!is_numeric($capacite)) {
        $capacite = 1;
        $msg .= '<div class="alert alert-warning mt-3">Attention,<br>Cette salle n\'ayant pas de capacité, la capacité été mis à 1.</div>';
    }


    // Contrôle sur l'image
    // Les pièces jointes sont dans $_FILES
    // L'indice (le name du champ) qui sera dans $_FILES ne sera jamais vide car c'est un sous tableau array
    // Pour être sûr qu'un fichier a été chargé, on vérifie si l'indice name dans ce sous tableau n'est pas vide.
    if (!empty($_FILES['photo']['name'])) {
        // pour éviter qu'une nouvelle image ayant le même nom qu'une image déjà enregistrée, on renomme le nom de l'image en rajoutant la référence qui est unique.
        $photo = uniqid() . '-' . $_FILES['photo']['name'];

        // Nous devons vérifier l'extension de l'image afin d'être sûr que c'est bien une image et que le format est compatible pour le web
        // tableau array contenant les extensions acceptées : 
        $tab_extension = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        // on récupère l'extension du fichier, les extensions peuvent avoir une nb de caractère différent (jpg / jpeg / js ...)
        // Pour être sûr de récupérer l'extension complète, on va découper la chaine en partant de la fin et on remonte jusqu'à un caractère fourni en argument : le point . (même approche que dans la fonction class_active() voir le fichier functions.php)
        // exemple : strrchr('image.png', '.') => on récupère .png
        // au passage on enlève le . de l'extension avec substr()

        $extension = strrchr($photo, '.'); // exemple : strrchr('image.png', '.') => on récupère .png
        $extension = substr($extension, 1); // exemple : pour .png => on récupère png
        $extension = strtolower($extension); // on passe la chaine en minuscule pour pouvoir la tester // exemple : PNG => on récupère png

        // https://www.php.net/manual/fr/function.in-array.php
        if (in_array($extension, $tab_extension)) {
            // format ok
            // on retravaille le nom de l'image pour enlever les caractères spéciaux et les espaces
            $photo = preg_replace('/[^A-Za-z0-9.\-]/', '', $photo);
            // echo $photo;

            // s'il n'y a pas eu d'erreur dans nos contrôles, on copie l'image depuis le form vers un dossier
            if ($erreur == false) {
                // copy(emplacement_de_base, emplacement_cible);
                // l'image est conservée à la validation du formulaire dans l'indice de $_FILES['photo']['tmp_name']
                copy($_FILES['photo']['tmp_name'], ROOT_PATH . PROJECT_PATH . 'assets/img-salles/' . $photo);
            }
        } else {
            // format invalide
            $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Format de l\'image invalide, format acceptés : jpg / jpeg /  png / gif / webp.</div>';
            // cas d'erreur 
            $erreur = true;
        }
    } // fin : une photo a été chargé

    // on enregistre en BDD
    if ($erreur == false) {

        // si l'id_salle n'est pas vide, on est dans une modif :
        if (!empty($id_salle)) {
            $enregistrement = $pdo->prepare("UPDATE salle SET titre = :titre, description  = :description, photo = :photo, capacite = :capacite, categorie = :categorie, 
            pays = :pays, ville = :ville, adresse = :adresse, cp = :cp WHERE id_salle = :id_salle");
            $enregistrement->bindParam(':id_salle', $id_salle, PDO::PARAM_STR);
        } else {
            $enregistrement = $pdo->prepare("INSERT INTO salle (titre, description, photo, capacite, categorie, pays, ville, adresse, cp) 
            VALUES (:titre, :description, :photo, :capacite, :categorie, :pays, :ville, :adresse, :cp)");
        }

        $enregistrement->bindParam(':titre', $titre, PDO::PARAM_STR);
        $enregistrement->bindParam(':description', $description, PDO::PARAM_STR);

        $enregistrement->bindParam(':photo', $photo, PDO::PARAM_STR);

        $enregistrement->bindParam(':capacite', $capacite, PDO::PARAM_STR);
        $enregistrement->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $enregistrement->bindParam(':pays', $pays, PDO::PARAM_STR);
        $enregistrement->bindParam(':ville', $ville, PDO::PARAM_STR);
        $enregistrement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $enregistrement->bindParam(':cp', $cp, PDO::PARAM_STR);
        $enregistrement->execute();
    }
} // fin des isset

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// RECUPERATION DES INFOS DES SALLES A MODIFIER
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
if (isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_salle'])) {
    // pour la modification, on lance une requete en bdd et on affecte les infos dans les variables présentent dans les value de nos champs du form
    $recup_infos = $pdo->prepare("SELECT * FROM salle WHERE id_salle = :id_salle");
    $recup_infos->bindParam(':id_salle', $_GET['id_salle'], PDO::PARAM_STR);
    $recup_infos->execute();

    $infos_salle = $recup_infos->fetch(PDO::FETCH_ASSOC);

    $id_salle = $infos_salle['id_salle'];
    $titre = $infos_salle['titre'];
    $description = $infos_salle['description'];
    $capacite = $infos_salle['capacite'];
    $categorie = $infos_salle['categorie'];
    $pays = $infos_salle['pays'];
    $ville = $infos_salle['ville'];
    $adresse = $infos_salle['adresse'];
    $cp = $infos_salle['cp'];
    $ancienne_photo = $infos_salle['photo'];

}


//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// RECUPERATION DES SALLES EN BDD
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
$liste_salle = $pdo->query("SELECT * FROM salle ORDER BY categorie, titre");

// Les affichages dans la page commencent depuis la ligne suivante :
include '../inc/header.inc.php';
include '../inc/nav.inc.php';
// var_dump($_POST);
// var_dump($_FILES);
?>

<main class="container">
    <br>
    <br>
    <div class="p-5 rounded">
        <h1 class="pb-4 border-bottom">Gestion des salles</h1>
        <p class="lead">Cher Administrateur, bienvenue sur la gestion des salles.</p>
        <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  
        ?>
        <div>
            <img class="illustration" src="../assets/img/illustration7.png" alt="Une image de la gestion salle.">
        </div>
    </div>
        
    </div>
    <div class="row">
        <div class="col-12 mt-5">
            <form method="post" action="" class="border p-3" enctype="multipart/form-data">

                <input type="hidden" name="id_salle" value="<?php echo $id_salle ?>">
                <input type="hidden" name="ancienne_photo" value="<?php echo $ancienne_photo ?>">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <!-- <select class="form-control" id="titre" name="titre"> -->
                            <input type="text" class="form-control" id="titre" rows="3" name="titre" value="<?php echo $titre; ?>">
                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
                        <!-- <textarea class="form-control" id="description" name="description">Cette salle vous premettra de recevoir les collaborateurs en petit comité.</textarea>
                        <textarea class="form-control" id="description" name="description">Cette salle vous permettra de travailler au calme.</textarea> -->
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="mb-4">
                        <label for="capacite" class="form-label">Capacité</label>
                        <select class="form-control" id="capacite" name="capacite">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="80">80</option>
                            <option value="150">150</option>
                            <option value="250">250</option>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="capacite" class="form-label">Catégorie</label>
                        <select class="form-control" id="categorie" name="categorie">

                            <option value="Réunion">Réunion</option>
                            <option value="Bureau">Bureau</option>
                            <option value="Conférence">Conférence</option>
                            <option value="Réception">Réception</option>
                        </select>

                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="pays" class="form-label">Pays</label>
                        <select class="form-control" id="pays" name="pays">
                            <option></option>
                            <option <?php if ($pays == 'France') {
                                        echo 'selected';
                                    } ?>>France</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ville" class="form-label">Ville</label>
                        <select class="form-control" id="ville" name="ville">
                            <option>Ville</option>
                            <option <?php if ($ville == 'Paris') {
                                        echo 'selected';
                                    } ?>>Paris
                            </option>
                            <option <?php if ($ville == 'Lyon') {
                                        echo 'selected';
                                    } ?>>Lyon
                            </option>
                            <option <?php if ($ville == 'Marseille') {
                                        echo 'selected';
                                    } ?>>Marseille
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $adresse; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="cp" class="form-label">Code Postal</label>
                        <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp; ?>">
                    </div>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-outline-white text-white w-100" id="enregistrement" name="enregistrement" value="Enregistrement">
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
    <!-- Affichage du tableau des salles -->

    <div class="row">
        <div class="col-12 mt-5">
            <table class="table table-bordered">
                <tr class="bg-light text-secondary text-center align-middle">
                    <th>Id</th>
                    <th>titre</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Capacité</th>
                    <th>Catégorie</th>
                    <th>Pays</th>
                    <th>Ville</th>
                    <th>Adresse</th>
                    <th>CP</th>
                    <th>Modif</th>
                    <th>Suppr</th>
                </tr>


                <?php
                while ($ligne = $liste_salle->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $ligne['id_salle'] . '</td>';
                    echo '<td>' . $ligne['titre'] . '</td>';
                    echo '<td>' . $ligne['description'] . '</td>';
                    echo '<td class="text-center"><img src="' . URL . 'assets/img-salles/' . $ligne['photo'] . '" class="img-thumbnail" width="70"></td>';
                    echo '<td>' . $ligne['capacite'] . ' </td>';
                    echo '<td>' . $ligne['categorie'] . '</td>';
                    echo '<td>' . $ligne['pays'] . '</td>';
                    echo '<td>' . $ligne['ville'] . '</td>';
                    echo '<td>' . $ligne['adresse'] . '</td>';
                    echo '<td>' . $ligne['cp'] . '</td>';

                    echo '
                        <td class="text-center"><a href="?action=modifier&id_salle=' . $ligne['id_salle'] . '" class="btn-warning text-white"><i class="fas fa-edit"></i></a></td>';

                    echo '<td class="text-center"><a href="?action=supprimer&id_salle=' . $ligne['id_salle'] . '" class=" btn-danger confirm_delete" ><i class="far fa-trash-alt"></i></a></td>';

                    // si on veut faire le  bouton dans un form
                    // echo '<td class="text-center"><form action="" ><input type="hidden" name="action" value="supprimer"><input type="hidden" name="id_article" value="' . $ligne['id_article'] . '"><button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button></form></td>';

                    echo '</tr>';
                }
                ?>

            </table>
        </div>
    </div>

    <br>
    <br>

</main>

<?php
include '../inc/footer.inc.php';
?>