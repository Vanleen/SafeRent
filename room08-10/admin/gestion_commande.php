<?php
include '../inc/init.inc.php';
include '../inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur n'est pas admin, on le redirige vers connexion.php
if (!user_is_admin()) {
    header('location:../connexion.php');
    exit(); // bloque l'exécution du code à la suite de cette ligne.
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// SUPPRESSION COMMANDES
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_commande'])) {
    $suppression = $pdo->prepare("DELETE FROM commande WHERE id_commande = :id_commande");
    $suppression->bindParam(':id_commande', $_GET['id_commande'], PDO::PARAM_STR);
    $suppression->execute();
}


//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// RECUPERATION DES COMMANDES EN BDD
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
$liste_commande = $pdo->query("SELECT * FROM commande, salle, produit, membre WHERE salle.id_salle = produit.id_salle AND membre.id_membre = commande.id_membre AND produit.id_produit = commande.id_produit ORDER BY id_commande");

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
        <h1 class="pb-4 border-bottom">Gestion des commandes</h1>
        <p class="lead">Cher Administrateur, bienvenue sur la gestion des commandes.</p>
        <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  
        ?>
        <div>
            <img class="illustration" src="../assets/img/illustration3.png" alt="Une image de la gestion salle.">
        </div>
    </div>

    <!-- Affichage du tableau des commandes -->
    <div class="row">
        <div class="col-12 mt-5">
            <table class="table table-bordered">
                <tr class="bg-light text-secondary text-center align-middle">
                    <th>Id Commande</th>
                    <th>Id Membre</th>
                    <th>Id Produit</th>
                    <th>Date commande</th>
                    <th>Suppr</th>
                </tr>


                <?php
                while ($ligne = $liste_commande->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr class="text-center align-middle ">';
                    echo '<td>' . $ligne['id_commande'] . '</td>';


                    echo '<td>' . $ligne['id_membre'] .' - ' . $ligne['email'] . '</td>';
                        echo '<td>' . $ligne['id_produit'] .' - ' . $ligne['titre'] . '<br>'. $ligne['date_arrivee']. ' au ' . $ligne['date_depart'] . '<br>' . '<img src="' . URL . 'assets/img-salles/' . $ligne['photo'] . '" class="img-thumbnail" width="70"></td>';

                    // var_dump($ligne);
                    echo '<td>' . $ligne['date_commande'] . '</td>';
                

                    echo '<td><a href="?action=supprimer&id_commande=' . $ligne['id_commande'] . '" class="btn-danger confirm_delete" ><i class="far fa-trash-alt"></i></a></td>';
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
