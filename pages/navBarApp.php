<?php var_dump($title) ?>

<nav class="nav_app">
    <ul>
        <div class="nav_left">
            <li><a href="../index.php"><img class="img_logo" src="../image/dumbbell.png"></a></li>
            <li><a href="../index.php">MuscuProgress</a></li>
        </div>

        <div class="nav_mid">
            <li><a class="link_signin 
                    <?php if ($title == "App") { ?>
                        active_link
                    <?php } else { ?>
                        no_active
                <?php } ?>
                        " href="app.php">Exercice</a></li>
            <li><a class="link_signup
            <?php if ($title == "Profil") { ?>
                        active_link
                    <?php } else { ?>
                        no_active
                <?php } ?>
                    " href="profil.php">Profil</a></li>
            <?php if ($_SESSION['role_admin'] == 1) { ?>
                <li><a class="
                <?php if ($title == "Admin") { ?>
                        active_link
                    <?php } else { ?>
                        no_active
                <?php } ?>
                    " href="./admin_users.php">Admin</a></li>
            <?php } ?>
        </div>

        <div class="nav_right">
            <li><a href="deconnexion.php">Deconnexion</a></li>
        </div>
    </ul>
</nav>