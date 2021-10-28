<?php

include '../inc/init.inc.php';
include '../inc/functions.inc.php';

// Restriction d'accès
if (!user_is_admin()) {
  header('location:../connexion.php');
  exit();
}


//  SUPPRESSION avis
// ----------------------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_avis'])) {
  $suppression = $pdo->prepare("DELETE FROM avis WHERE id_avis = :id_avis");
  $suppression->bindParam(':id_avis', $id_avis, PDO::PARAM_STR);
  $suppression->execute();
}



// modification 
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

$id_avis = '';
$id_membre = '';
$id_salle =  '';
$commentaire =  '';
$note = '';
$date_enregistrement = '';



// Enregistrement en BDD
//------------------------------------------
if (isset($_POST['commentaire'])) {


  $commentaire = trim($_POST['commentaire']);

  if (!empty($_POST['id_avis'])) {
    $id_avis = trim($_POST['id_avis']);
  }
  // Déclaration d'une variable nous permettant de savoir s'il y a eu des erreurs dans nos contrôles
  $erreur = false;

  if (!empty($id_avis)) {
    $enregistrement = $pdo->prepare("UPDATE avis SET commentaire = :commentaire WHERE id_avis = :id_avis");
    $enregistrement->bindParam(':id_avis', $id_avis, PDO::PARAM_STR);
  }
  // $enregistrement->bindParam(':id_membre', $id_membre, PDO::PARAM_STR);
  // $enregistrement->bindParam(':id_salle', $id_salle, PDO::PARAM_STR);
  $enregistrement->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
  // $enregistrement->bindParam(':note', $note, PDO::PARAM_STR);
  $enregistrement->execute();
}

if (isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_avis'])) {
  $recup_infos = $pdo->prepare("SELECT * FROM avis WHERE id_avis = :id_avis");
  $recup_infos->bindParam(':id_avis', $_GET['id_avis'], PDO::PARAM_STR);
  $recup_infos->execute();

  $infos_avis = $recup_infos->fetch(PDO::FETCH_ASSOC);

  $id_avis = $infos_avis['id_avis'];
  $id_membre = $infos_avis['id_membre'];
  $id_salle = $infos_avis['id_salle'];
  $commentaire = $infos_avis['commentaire'];
  $note = $infos_avis['note'];
  $date_enregistrement = $infos_avis['date_enregistrement'];
}


//  RECUPERATION DES AVIS EN BDD
// ----------------------------------------------------------------------

$liste_avis = $pdo->query("SELECT * FROM avis INNER JOIN salle USING (id_salle) INNER JOIN membre USING (id_membre) ORDER BY id_avis; ");



// Les affichages dans la page commencent depuis la ligne suivante
//-----------------------------------------------------------------
include '../inc/header.inc.php';
include '../inc/nav.inc.php';

?>



<main class="container">
  <br>
  <br>
  <div class="p-5 rounded">
    <h1 class="pb-4 border-bottom">Gestion des avis</h1>
    <p class="lead">Cher Administrateur, bienvenue sur la gestion des avis.</p>
    <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  
    ?>
    <div>
      <img class="illustration" src="../assets/img/illustration6.png" alt="Une image de la gestion salle.">
    </div>
  </div>
  <form action="" method="POST">
    <input type="hidden" name="id_avis" id="id_avis" value="<?php echo $id_avis; ?>">
    <div class="mb-3">
      <label for="commentaire" class="form-label">Commentaire à modifier :</label>
      <textarea type="text" class="form-control mt-2" name="commentaire" rows="5"><?php echo $commentaire ?></textarea>
      <input type="submit" class="btn btn-white text-white w-100 mt-2" id="modification" name="modification" value="Modification">
    </div>
  </form>


  <!-- Affichage du tableau des avis -->

  <div class="col-12">
    <table class="table table-striped table-hover shadow my-5 mx-auto">
      <tr class="bg-indigo text-dark text-center">
        <th>ID avis</th>
        <th>ID membre</th>
        <th>ID salle</th>
        <th>commentaire</th>
        <th>note</th>
        <th>Date enregistrement</th>
        <th>Modif.</th>
        <th>Suppr.</th>

      </tr>


      <?php
      while ($ligne = $liste_avis->fetch(PDO::FETCH_ASSOC)) {

        $date_enregistrement = date('d/m/Y à H:m ', strtotime($ligne['date_enregistrement']));

        echo '<tr>';
        echo '<td class="text-center ">' . $ligne['id_avis'] . '</td>';
        echo '<td class="text-center ">' . $ligne['id_membre'] . ' - ' . $ligne['email'] . '</td>';
        echo '<td class="text-center ">' . $ligne['id_salle'] . ' - ' . $ligne['categorie'] . ' ' . $ligne['titre'] .  '</td>';

        echo '<td class="text-center ">' . $ligne['commentaire'] . '</td>';
        echo '<td class="text-center ">' . $ligne['note'] . '/10 </td>';
        echo '<td class="text-center ">' . $date_enregistrement . '</td>';

        echo '<td class="text-center "><a href="?action=modifier&id_avis=' . $ligne['id_avis']  . '" class=" btn-warning text-white"> <i class="fas fa-edit"></i></a> </td>';
        echo '<td class="text-center" ><a href="?action=supprimer&id_avis=' . $ligne['id_avis']  . '" class=" btn-danger confirm_delete"> <i class="fas fa-trash-alt"></i> </a></td>';

        echo '</tr>';
      }
      ?>
    </table>
  </div>
</main>


<?php
include '../inc/footer.inc.php';
?>