<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

if (isset($_GET['id_salle'])) {

  $recup_salle = $pdo->prepare("SELECT * FROM produit RIGHT JOIN salle USING (id_salle) LEFT JOIN commande USING (id_produit) WHERE id_salle = :id_salle");
  $recup_salle->bindParam('id_salle', $_GET['id_salle'], PDO::PARAM_STR);
  $recup_salle->execute();

  // On vérifie si on a une ligne (si on a bien recupéré une salle)
  if ($recup_salle->rowCount() < 1) {
    // On redirige vers index.php
    header('location:index.php');
  }
} else {
  header('location:index.php');
}

//-----------------------------------------------------------------------------

//variable confirmation commande
$confirmation = '';
//Enregistrement de la commande

if (isset($_POST['id_produit']) && !empty($_POST['id_produit']) && isset($_POST['reserver'])) {

  $enregistrement2 = $pdo->prepare("INSERT INTO commande (id_membre,id_produit, date_commande) VALUES (:id_membre,:id_produit, NOW()) ");

  $enregistrement2->bindParam(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
  $enregistrement2->bindParam(':id_produit',  $_POST['id_produit'], PDO::PARAM_STR);
  $enregistrement_reussi = $enregistrement2->execute();

  $change_produit = $pdo->prepare("UPDATE produit SET etat ='Réservée' WHERE id_produit = :id_produit AND etat = 'Libre'");
  $change_produit->bindParam(':id_produit', $_POST['id_produit'], PDO::PARAM_STR);
  $change_produit->execute();
}
// if (isset($enregistrement_reussi) && $enregistrement_reussi) {
//   $msg = '<div class="alert alert-success mt-3">Réservation reussi!</div>';
// }
//----------------------------------------------------------------------------

// On traite la ligne avec fetch
$infos_salle = $recup_salle->fetch(PDO::FETCH_ASSOC);

$tableau_salle = $pdo->prepare("SELECT * FROM produit LEFT JOIN salle ON produit.id_salle = salle.id_salle WHERE produit.id_salle = :id_salle AND date_arrivee > CURDATE() ORDER BY YEAR(date_arrivee)");
$tableau_salle->bindParam('id_salle', $_GET['id_salle'], PDO::PARAM_STR);
$tableau_salle->execute();

//-----------------------------------------------------------------------------

// Variable vide destinée à afficher des commentaires utilisateur
$msg = '';

// Variable destinée à afficher les requetes exécutées pour voir les soucis de sécurité
$req = '';

// - 04 - Récupération des saisies du form avec controle 
if (isset($_POST['commentaire']) && isset($_POST['note'])) {
  $commentaire = trim($_POST['commentaire']);
  $note = trim($_POST['note']);

  // Contrôle : le pseudo et le commentaire ne doivent pas être vides.

  if (empty($commentaire)) {
    $msg .= '<div class="alert alert-danger mt-3">Attention, le commentaire est obligatoire</div>';
  }
  if (empty($note)) {
    $msg .= '<div class="alert alert-danger mt-3">Attention, la note est obligatoire</div>';
  }

  if (empty($msg)) {
    $enregistrement = $pdo->prepare("INSERT INTO avis (id_membre, id_salle, commentaire, note, date_enregistrement) VALUES (:id_membre, :id_salle, :commentaire, :note, NOW())");

    $enregistrement->bindParam(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
    $enregistrement->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
    $enregistrement->bindParam(':note', $note, PDO::PARAM_STR);
    $enregistrement->bindParam(':id_salle', $infos_salle['id_salle'], PDO::PARAM_STR);
    $enregistrement->execute();
  }

} // Fin des isset

$avis = $pdo->prepare("SELECT * FROM avis INNER JOIN membre USING (id_membre) INNER JOIN salle USING (id_salle) WHERE id_salle = :id_salle ");
$avis->bindParam('id_salle', $_GET['id_salle'], PDO::PARAM_STR);
$avis->execute();



// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>

<main id="main" data-aos="fade-up">


  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2></h2>
        <ol>
          <li><a href="index.php">Accueil</a></li>
          <li>Détails salle</li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Portfolio Details Section ======= -->
  <section id="portfolio-details" class="portfolio-details">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-8">
          <div class="portfolio-details-slider swiper-container">
            <div class="swiper-wrapper align-items-center">

              <div class="swiper-slide">
                <img src="<?php echo URL . 'assets/img-salles/' . $infos_salle['photo']; ?>" alt="Image de la salle <?php echo $infos_salle['titre']; ?>">
              </div>

              <div class="swiper-slide">
                <img src="<?php echo URL . 'assets/img-salles/' . $infos_salle['photo']; ?>" alt="Image de la salle <?php echo $infos_salle['titre']; ?>">
              </div>

            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
        <br>



        <div class="col-lg-4">
          <div class="portfolio-info">

            <h3><?php echo $infos_salle['titre'] ?></h3>

            <ul>
              <li><strong>Description : </strong><?php echo $infos_salle['description'] ?></li>
              <hr>
              <li><strong>Catégorie : </strong> <?php echo $infos_salle['categorie'] ?></li>
              <li><strong>Adresse : </strong> <?php echo $infos_salle['adresse'] ?></li>
              <li><strong>Ville : </strong> <?php echo $infos_salle['ville'] ?></li>
              <li><strong>Capacité : </strong><?php echo $infos_salle['capacite'] ?></li>
              <li><strong>Etat : </strong><?php echo $infos_salle['etat'] ?></li>
            </ul>
          </div>

          <br>
          <br>
          <div class="align-middle">
            <a data-aos="fade-up" data-aos-delay="200" href="<?php echo URL; ?>#portfolio" class="btn-get-second scrollto">Liste des salles</a>
          </div>

        </div>
        <br>
        <br>

        <section id="mappy">
          <br>
          <br>

          <div class="col-lg-8 mx-auto pb-10 mt-10">
            <div class="portfolio-info">

              <span><i class="bi bi-geo-alt"></i></span>
              <h3>Localisez votre salle</h3>
              <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2607.3250612774436!2d2.470541516262813!3d49.194392784942316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e648177527031f%3A0x38ba74c5025e19d5!2sRue%20du%20Conn%C3%A9table%2C%2060500%20Chantilly!5e0!3m2!1sfr!2sfr!4v1633625291942!5m2!1sfr!2sfr" class="google-maps shadow" width="100%" height="200" style="border:0;" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </section>


        <br>
        <br>

      

          <div id="disposalle">

            <div class="row pt-10 mx-auto mt-5">
              <div class="col-sm-8 col-md-10 col-lg-8  mx-auto">

                <h3 style="text-align: center; font-family: 'Montserrat', sans-serif;">Tableau des disponibilités </h3>
                <table class="table table-striped pt-5 pb-10">
                <tr class="bg-light text-secondary text-center     align-middle">
                    <th>Arrivée</th>
                    <th>Départ</th>
                    <th>État</th>
                    <th>Prix</th>
                    <th>Réserver</th>
                  </tr>

                  <br>

                  <form action="" method="POST" class="pb-5">
                    <?php


                    while ($produit = $tableau_salle->fetch(PDO::FETCH_ASSOC)) {

                      if (!$produit['etat'] == 'Réservée') {
                        $produit['etat'] = 'Libre';
                      }


                      $date_arrivee = date('d/m/Y ', strtotime($produit['date_arrivee']));
                      $date_depart = date('d/m/Y ', strtotime($produit['date_depart']));
                      // $date_jour = date("d/m/Y");;
                      // var_dump($salle);     

                      if ($date_arrivee !== null && $date_depart !== null) {


                        echo '<tr>';
                        echo '<td class="text-center ">' . $date_arrivee . '</td>';
                        echo '<td class="text-center ">' . $date_depart . '</td>';


                        echo '<td class="text-center">' . $produit['etat'] . '</td>';
                        echo '<td class="text-center ">' . $produit['prix'] . '€</td>';

                        if (user_is_connected()) {
                          if ($produit['etat'] == 'Réservée') {

                            echo "<td class='text-center'><button type='submit' class='btn btn-outline-secondary w-100' disabled>Non disponible</button></td>";
                          } else {
                            echo "<input type='hidden' name='id_produit' value=" . $produit['id_produit'] . ">";
                            echo "<td class='text-center'><button type='submit' class='btn btn-outline-white text-white w-100' name='reserver'>Réserver</button></td>";
                          }
                        } else {
                          echo "<td class='text-center '><div class='mt-5 mb-5'> Veuillez vous <a href='connexion.php'>connecter</a> ou vous <a href='inscription.php'>inscrire</a> afin de réserver</div> </td>";
                        }
                      } else {
                        echo '<div class="section-content">';
                        echo '<span class="text-center">Pas de disponibilités</span>';
                        echo '</div>';
                      }
                    }



                    ?>
                  </form>
                </table>
                <br>
                <br>

              </div>

              <br>
              <br>

              <?php
              // on  affiche la variable qui peut contenir des commentaires pour l'utilisateur.

              // echo $req;

              echo $msg;


              ?>

              <br>
              <br>


              <div class="avis">

                <div class="col-lg-8 mx-auto col-sm-8 col-md-10 col-lg-8 pt-10 mx-auto">
                  <div class="portfolio-info w-100">
                    <h3 style="text-align: center; font-family: 'Montserrat', sans-serif;"><span><i class="fas fa-bookmark"></i></span> Parce que votre avis compte </h3>

                    <div class="mb-6">
                      <label for="commentaire" class="form-label">Commentaire</label>
                      <textarea class="form-control" id="commentaire" name="commentaire"></textarea>
                    </div>
                    <div class="mb-6">
                      <label for="note" class="form-label">Note</label>
                      <input type="text" class="form-control" id="note" name="note">
                    </div>
                  </div>
                  <div class="mb-6">

                    <button type="submit" class="btn btn-white text-white w-100" id="enregistrer" name="enregistrer">Enregistrer</button>
                  </div>



                </div>
                <div class="row mt-5">
                  <div class="col-6 mx-auto">
                    <!-- Affichage des commentaire -->
                    <?php
                    while ($ligne_avis = $avis->fetch(PDO::FETCH_ASSOC)) {
                      // var_dump($ligne_avis);
                      $date_avis = date('d/m/Y à H:m', strtotime($ligne_avis['date_enregistrement']));
                      echo '<strong>Pseudo : </strong>' . ' ' . $ligne_avis['pseudo'] . '<br> Le ' . $date_avis . '<br>
                      <strong>Note : </strong>' . $ligne_avis['note'] . '/10 
                      <br>
                      <strong>Commentaire : </strong> ' . $ligne_avis['commentaire'] . '<hr>';
                    }

                    ?>
                  </div>
                </div>
        




  </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->
<?php
include 'inc/footer.inc.php';
?>