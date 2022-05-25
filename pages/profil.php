<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
    require '../model/Weight.php'
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/profil.css">

        <title>Profil</title>
    </head>

    <body>
        <nav class="nav_app">
            <ul>
                <div class="nav_left">
                    <li><a href="../index.php"><img class="img_logo" src="../image/dumbbell.png"></a></li>
                    <li><a href="../index.php">MuscuProgress</a></li>
                </div>

                <div class="nav_mid">
                    <li><a class="link_signin no_active" href="app.php">Exercice</a></li>
                    <li><a class="link_signup active_link" href="profil.php">Profil</a></li>
                    <?php if ($_SESSION['role_admin'] == 1) { ?>
                        <li><a class="no_active" href="admin.php">Admin</a></li>
                    <?php } ?>
                </div>

                <div class="nav_right">
                    <li><a href="deconnexion.php">Deconnexion</a></li>
                </div>
            </ul>
        </nav>

        <div class="weight">
            <h2>Suivez votre <span class="red">poids</span> tout au long des semaines</h2>
            <div>
                <?php
                $weight = new Weight;
                $allWeight = $weight->fetchAllWeight();
                foreach ($allWeight as $weight) {
                    $weightReplace = str_replace(".", "/", $weight['all_date']);
                ?>

                    <p class="date_and_weight"><?= $weightReplace ?> - <span class="red"><?= $weight['weight'] ?>kg</span></p>
                <?php } ?>
            </div>
            <div class="block_weight" id="add_weight">
                <ion-icon name="add-outline"></ion-icon>
            </div>
        </div>

        <section class="weight_section">
            <canvas id="weight_canvas" aria-label="chart" role="img"></canvas>
        </section>
        
        <div id="registration_success">
            <div class="popup_registration">
                <p class="close_btn">
                    <ion-icon name="close-outline"></ion-icon>
                </p>
                <h1>Veuillez ajouter votre <span class="red"> poids de cette semaine</span></h1>
                <form action="../config/addWeight.php" method="get">
                    <div class="input_and_label pseudo">
                        <?php
                        $date = date('d.m.Y');
                        $good_format = strtotime($date);
                        $number_week = date('W', $good_format);
                        $year = date('Y');
                        ?>
                        <label for="week_weight">Poids</label>
                        <input type="number" name="week_weight" id="week_weight" value="2">
                        <input type="hidden" name="user" value="<?= $_SESSION['id'] ?>">

                        <input type="hidden" name="week_and_year" value="<?= $number_week / $year ?>">
                    </div>
                    <input type="submit" class="submit_style" value="Ajouter">
                </form>
            </div>
        </div>

        <div class="informations">
            <div class="input_and_label pseudo">
                <input type="email" name="email" id="email" value="<?= $_SESSION['username'] ?>">
                <label for="email" id="label_email">Pseudo</label>
            </div>

            <div class="input_and_label password">
                <input type="password" name="password" id="password">
                <label for="password" id="label_password">Ancien Mot de passe</label>
            </div>

            <div class="input_and_label password">
                <input type="password" name="new_password" id="new_password">
                <label for="new_password" id="label_new_password">Nouveau mot de passe</label>
            </div>
            <input type="submit" class="submit_style" value="Modifier">
        </div>
    </body>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../js/profil.js"></script>
    <script src="../js/popup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="../js/graphic.js"></script>

    </html>

<?php } else {
    echo "Veuillez vous connectez";
}


?>