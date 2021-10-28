<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';


// Récupération des villes
$liste_ville = $pdo->query("SELECT DISTINCT ville FROM salle ORDER BY ville");

// Récupération des catégories 
$liste_categories = $pdo->query("SELECT DISTINCT categorie FROM salle ORDER BY categorie"); // requete

// Récupération capacités
$liste_capacites = $pdo->query("SELECT DISTINCT capacite FROM salle ORDER BY capacite");

// Récupération des salles
if (isset($_GET['categorie'])) {
  $liste_salle = $pdo->prepare("SELECT * FROM salle LEFT JOIN produit USING (id_salle) WHERE categorie = :categorie ORDER BY categorie, titre");
  $liste_salle->bindParam(':categorie', $_GET['categorie'], PDO::PARAM_STR);
  $liste_salle->execute();
} else if (isset($_GET['ville'])) {
  $liste_salle = $pdo->prepare("SELECT * FROM salle LEFT JOIN produit USING (id_salle) WHERE ville = :ville ORDER BY titre");
  $liste_salle->bindParam(':ville', $_GET['ville'], PDO::PARAM_STR);
  $liste_salle->execute();
} else {
  $liste_salle = $pdo->query("SELECT * FROM salle ORDER BY titre, ville");
}
// var_dump($liste_salle);


// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>

<main id="main">
  <br>
  <br>


  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Services</h2>
        <br>
      </div>

      <div class="row">
        <div class="col-lg-6 order-2 order-lg-1">
          <div class="icon-box mt-5 mt-lg-0" data-aos="fade-up">
            <i class="bx bx-receipt"></i>
            <h4>Salles de Réunions</h4>
            <p>Des salles adaptées pour vos comités d'entreprises, vos meetings, les conférences, les réunions d'affaires, en toute simplicité</p>
          </div>
          <div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="100">
            <i class="bx bx-cube-alt"></i>
            <h4>Salles de réception</h4>
            <p>Recevez et formez vos collaborateurs, dans des espaces équipées et adaptées à vos besoins. </p>
          </div>
          <div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="200">
            <i class="bx bx-images"></i>
            <h4>Nos bureaux</h4>
            <p>Espace de travail disponible sous différentes capacités, pour recruter et travailler en équipe.</p>
          </div>
        </div>
        <div class="image col-lg-6 order-1 order-lg-2" style='background-image: url("<?php echo URL; ?>assets/img-salles/Dumas2.jpg");' data-aos="fade-left" data-aos-delay="100"></div>
      </div>

    </div>
  </section><!-- End Services Section -->

  <!-- ======= Liste des Salles Section ======= -->



  <section id="portfolio" class="portfolio">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Liste des Salles</h2>
        <br>
        <p>Organisez vos réunions, Recrutez, formez et travaillez avec vos équipes dans des salles équipées et adaptées</p>
      </div>

      <div class="col-sm-3 mt-5">
                    <ul class="list-group">
                        <li class="list-group-item1" aria-current="true">Catégories  </li>
                        <li class="list-group-item text-secondary"><a href="<?php echo URL; ?>fiche_produit.php">Toutes les salles</a></li>
                        <?php
                        while ($ligne = $liste_categories->fetch(PDO::FETCH_ASSOC)) {
                            echo '<li class="list-group-item text-secondary"><a href="?categorie=' . $ligne['categorie'] . '">' . ucfirst($ligne['categorie']) . '</a></li>';
                        }
                        ?>
                        <!-- <li class="list-group-item bg-dark text-white" aria-current="true">Capacités : </li>
                        <li class="list-group-item"><a href="<?php echo URL; ?>"></a></li>

                        <li class="list-group-item bg-dark text-white" aria-current="true">Prix : </li>
                        <li class="list-group-item"><a href="<?php echo URL; ?>"></a></li>

                        <li class="list-group-item bg-dark text-white" aria-current="true">Période : </li>
                        <li class="list-group-item"><a href="<?php echo URL; ?>"></a></li> -->
                        <li class="list-group-item2" aria-current="true">Villes  </li>
                        <?php
                        // EXERCICE : listez les catégories (sans doublon) dans une liste ul li, les  catégories doivent être en lien a href=""
                        while ($ligne = $liste_ville->fetch(PDO::FETCH_ASSOC)) {
                            // var_dump($ligne);
                            echo '<li class="list-group-item"><a href="?ville=' . $ligne['ville'] . '">' . ucfirst($ligne['ville']) . '</a></li>';
                            // ucfirst() fonction prédéfinie pour avoir la première lettre d'une chaine en majuscule.
                        }
                        ?>
                    </ul>

                </div>
                
        <br>
        <br>
        <br>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
        <?php
        while ($ligne = $liste_salle->fetch(PDO::FETCH_ASSOC)) {

          // var_dump($ligne);
          if (empty($liste_salle)) {
          } else {
        ?>
            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-wrap">
                <img src="<?php echo  URL . 'assets/img-salles/' .  $ligne["photo"]; ?>" class="img-fluid" alt="" style="height: 280px;	">
                <div class="portfolio-info">
                  <h4><?php echo $ligne["titre"];  ?></h4>
                  <p><?php echo $ligne['ville']; ?></p>
                  <div class="portfolio-links">
                    <a href="<?php echo  URL . 'assets/img-salles/' .  $ligne["photo"]; ?>" data-gallery="portfolioGallery" class="portfolio-lightbox" title="<?php echo $ligne["titre"] ?>"><span><i class="bx bx-plus"></i></span></a>
                    <br>
                    <?php echo '<a href="fiche_produit.php?id_salle=' .  $ligne['id_salle'] . '" title="Plus de détails">Détails</a> ' ?>
                  </div>
                </div>
              </div>
            </div>
        <?php }
        } ?>


      </div>

    </div>
  </section><!-- End Portfolio Section -->

  <br>
  <br>
  <!-- ======= Pourquoi nous? ======= -->
  <section id="why-us" class="why-us">
    <div class="container-fluid">

      <div class="row">

        <div class="col-lg-7 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-stretch">

          <div class="content" data-aos="fade-up">
            <h3>Pourquoi Nous?<strong><br> Room Agency fait toute la différence !</strong></h3>
            <p>
              Aujourd'hui, chez Room Agency, c'est plus d'une dizaine de salles, bureaux, salle de conférences, meeting, entre autres, que nous mettons à votre disposition pour mener à bien vos activités. Toutes nos salles sont adaptées aux différentes situations, et suivent l'évolution des nouvelles technologies afin de rester encore et toujours plus performant.
            </p>
          </div>

          <div class="accordion-list">
            <ul>
              <li data-aos="fade-up" data-aos-delay="100">
                <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1"><span>01</span> La sécurité <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                  <p>
                    Que ce soit lors de vos transactions sur notre site pour réserver vos espaces de travail. Ou encore sur place, dans les locaux, nos services garantissent une sécurité 24h/24h.
                  </p>
                </div>
              </li>

              <li data-aos="fade-up" data-aos-delay="200">
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed"><span>02</span> L'écologie <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    Nous avons à coeur la préservation de la planète et c'est pourquoi toutes nos démarches visent à réduire l'impact sur notre environnement.
                  </p>
                </div>
              </li>

              <li data-aos="fade-up" data-aos-delay="300">
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed"><span>03</span> L'accessibilité <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    L'accessibilité! Oui parce qu'il est important pour nous que "TOUS" puissent bénéficier des services de Room Agency. Toutes nos salles et leurs accès sont prévus pour recevoir les personnes à mobilités différentes ou réduites. Des emplacements de parkings sont également prévus.
                  </p>
                </div>
              </li>

            </ul>
          </div>

        </div>

        <div class="col-lg-5 order-1 order-lg-2 align-items-stretch video-box" style='background-image: url("<?php echo URL; ?>assets/img/pots.jpg");' data-aos="zoom-in">
          <a href="https://www.youtube.com/watch?v=LIqQNG_q2us" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>
        </div>

      </div>

    </div>
  </section><!-- End Why Us Section -->





  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact section-bg">
    <div class="container">

      <div class="section-title">
        <h2>Contact</h2>
        <p>Pour toute demande, ecrivez-nous, nous serons heureux de vous lire !</p>
      </div>

      <div class="row">

        <div class="col-lg-4">
          <div class="info d-flex flex-column justify-content-center" data-aos="fade-right">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>Adresse</h4>
              <p>1 Avenue de Port Royale<br>75000 Paris</p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>Email</h4>
              <p>room@agency.com</p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>Phone</h4>
              <p>+01 02 03 04 05</p>
            </div>

          </div>

        </div>

        <div class="col-lg-8 mt-5 mt-lg-0">

          <form action="forms/contact.php" method="post" role="form" class="php-email-form" data-aos="fade-left">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Votre Nom" required>
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required>
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Votre message a été envoyé. Merci !</div>
            </div>
            <div class="text-center"><button type="submit">Envoyer</button></div>
          </form>

        </div>

      </div>

    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->

<?php
include 'inc/footer.inc.php';
?>