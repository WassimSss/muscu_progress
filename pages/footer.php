<footer>
    <div class="all_links">
        <div class="other">
            <ul>
                <?php if(!isset($_SESSION['id'])){ ?>
                <li>
                    <a href="./connexion.php">Se connecter</a>
                </li>
                <li>
                    <a href="./inscription.php">S'inscrire</a>
                </li>
                <?php } else { ?>
                <li>
                    <a href="./deconnexion.php">Deconnexion</a>
                </li>
                <?php } ?>
                <li>
                    <a href="./mentions_legales.php">Mentions Légales</a>
                </li>
            </ul>
        </div>
        <?php if (isset($_SESSION['id'])) { ?>
            <div class="footers_socials">
                <ul>
                    <li class="ul_title">Pages</li>
                    <li>
                        <a href="./app.php">Exercice</a>
                    </li>
                    <li>
                        <a href="./profil.php">Profil</a>
                    </li>
                    <?php if($_SESSION['role_admin'] == 1) { ?>
                    <li>
                        <a href="./admin_users.php">Admin</a>
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