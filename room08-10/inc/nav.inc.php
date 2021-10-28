<!-- ======= Hero Section ======= -->
<section id="hero">
  <div class="hero-container">
    <a href="index.php" class="hero-logo" data-aos="zoom-in"></a>
    <h1 data-aos="zoom-in">Room Agency</h1>
        <br>
    <h2 data-aos="fade-up">Salles de réunion | Salles de Réception | Bureaux</h2>
    <a data-aos="fade-up" data-aos-delay="200" href="<?php echo URL; ?>#services" class="btn-get-started scrollto">Bienvenue</a>
  </div>
</section><!-- End Hero -->

<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center">
  <div class="container d-flex align-items-center justify-content-between">

    <div class="logo">
      <a href="<?php echo URL; ?>index.php"><img src="<?php echo URL; ?>assets/img/logo70.png" alt="une image du logo" class="img-fluid"></a>
    </div>

    <nav id="navbar" class="navbar">
      <ul>
        <!-- <li class="nav-item">
                            <a class="nav-link <?php echo class_active('/inscription.php'); ?>" aria-current="page" href="<?php echo URL; ?>inscription.php">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo class_active('/connexion.php'); ?>" href="<?php echo URL; ?>connexion.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo class_active('/profil.php'); ?>" href="<?php echo URL; ?>profil.php">Profil</a>
                        </li> -->


        <?php if (user_is_connected()) { ?>

          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/index.php'); ?>" href="<?php echo URL; ?>index.php">Accueil</a>
          </li>
         
          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/#portfolio'); ?>" href="<?php echo URL; ?>#portfolio">Salles</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/profil.php'); ?>" href="<?php echo URL; ?>profil.php">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/connexion.php'); ?>" href="<?php echo URL; ?>connexion.php?action=deconnexion">Déconnexion</a>
          </li>
          <li><a class="nav-link <?php echo class_active('/#contact'); ?> scrollto" href="<?php echo URL; ?>#contact">Contact</a></li>


        <?php } else { ?>

          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/index.php'); ?>" href="<?php echo URL; ?>index.php">Accueil</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/#portfolio'); ?>" href="<?php echo URL; ?>#portfolio">Salles</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/connexion.php'); ?>" href="<?php echo URL; ?>connexion.php">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo class_active('/inscription.php'); ?>" href="<?php echo URL; ?>inscription.php">Inscription</a>
          </li>
          <li><a class="nav-link <?php echo class_active('/#contact'); ?> scrollto" href="<?php echo URL; ?>#contact">Contact</a></li>

        <?php } ?>


        <?php if (user_is_admin()) { ?>
        <li class="dropdown"><a href="#"><span>Administration</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
          <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_salles.php">Gestion des salles</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_produits.php">Gestion produits</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_commande.php">Gestion commandes</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_membres.php">Gestion membres</a></li>
                            
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_avis.php">Gestion des avis</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/statistiques.php">Statistiques</a></li>
            <?php } ?>
          </ul>
        </li>
        
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header><!-- End Header -->