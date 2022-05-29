<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>MuscuProgress</title>
</head>

<body>
    <nav class="nav_index">
        <ul>
            <div class="nav_left">
                <li><a href="index.php"><img class="img_logo" src="image/dumbbell.png"></a></li>
                <li><a href="index.php">MuscuProgress</a></li>
            </div>
            <div class="nav_right">
                <li><a class="link_signup" href="pages/inscription.php">Inscription</a></li>
                <li><a class="link_signin" href="pages/connexion.php">Connexion</a></li>
            </div>
        </ul>
    </nav>

    <section class="slogan_index">
        <h3><span class="red">L’application</span> de suivie journalier
            d’exercice de <span class="red">musculation</span></h3>
        <p class="grey">Entrez vos exercice, vos series, vos poids, vos dates et constatez votre progression</p>
    </section>

    <section class="presentation">
        <h4>Présentation de l'application web <span class="red">MuscuProgress</span></h4>
        <div class="entrer_exercice">
            <p>MuscuProgress est une application qui facilite le suivi de ses progrès en musculation, elle permet ainsi de suivre facilement la progression en terme de poids en fonction de l'objectif, perte ou prise de masse.
                Elle permet d'entrer les exercices pratiqués vous permettant ainsi de construire votre séance, et de suivre les anciennes séances.
            </p>
            <img src="./image/Entrer un exercice.jpg" alt="Séance du jour">
        </div>
        <div class="seance_jour">
            <p>Ceux-ci seront affichés vous permettant d'ajouter et de supprimer des exercices pendant votre séance de sport.</p>
            <img src="./image/Séance du jour.jpg" alt="Séance du jour">
        </div>
        <div class="seance_jour_x">
            <p>
                Parce que dans le domaine de la musculation, il est important d'être régulier, il existe dans l'application un calendrier vous permettant de voir les jours qui ont étaient travaillé, affichés en rouge.
                Vous pouvez ensuite cliquer sur ses cases rouges pour apercevoir la séance en question lors de ce jour-là.
            </p>
            <div>
                <img src="./image/Calendrier.jpg" alt="Calendrier">
                <img src="./image/Séance jour x.jpg" alt="Séance du jour cliqué">
            </div>
        </div>
    </section>

    <footer>
        <div class="all_links">
            <div class="other">
                <ul>
                    <?php if (!isset($_SESSION['id'])) { ?>
                        <li>
                            <a href="./pages/connexion.php">Se connecter</a>
                        </li>
                        <li>
                            <a href="./pages/inscription.php">S'inscrire</a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="./pages/deconnexion.php">Deconnexion</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="./pages/mentions_legales.php">Mentions Légales</a>
                    </li>
                </ul>
            </div>
            <?php if (isset($_SESSION['id'])) { ?>
                <div class="footers_socials">
                    <ul>
                        <li class="ul_title">Pages</li>
                        <li>
                            <a href="./pages/app.php">Exercice</a>
                        </li>
                        <li>
                            <a href="./pages/profil.php">Profil</a>
                        </li>
                        <?php if ($_SESSION['role_admin'] == 1) { ?>
                            <li>
                                <a href="./pages/admin_users.php">Admin</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>


        </div>
        <div class="copyright_div">
            <p class="copyright">&copy; 2022 MuscuProgress</p>
            <div class="links_copyright">
                <a class="mail" href="mailto:wassimassalmi@gmail.com">wassimassalmi@gmail.com</a>
                <a class="tel" href="tel:0102030405">0102030405</a>
            </div>
        </div>
    </footer>
</body>

</html>