<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
    require '../model/Weight.php';
    $title = 'Profil';

    require '../config/modifyProfil.php';
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/profil.css">

        <title><?= $title ?></title>
    </head>

    <body>
        <?php require '../pages/navBarApp.php';
        ?>

        <div class="weight">
            <h2>Suivez votre <span class="red">poids</span> tout au long des semaines</h2>
            <div>
                <?php
                $weight = new Weight;
                $allWeight = $weight->fetchAllWeight();
                foreach ($allWeight as $weight) {
                    $weightReplace = str_replace(".", "/", $weight['all_date']);
                ?>

                    <p class="date_and_weight"><?= $weightReplace ?> - <span class="red"><?= round($weight['weight'], 2) ?>kg</span></p>
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
                <form action="../config/addWeight.php" method="get" class="formpopup">
                    <div class="input_and_label pseudo">
                        <?php
                        $date = date('d.m.Y');
                        $good_format = strtotime($date);
                        $number_week = date('W', $good_format);
                        $year = date('Y');
                        ?>
                        <label for="week_weight">Poids</label>
                        <input type="number" name="week_weight" id="week_weight" value="60" step="0.01" min="0">
                        <input type="hidden" name="week_and_year" value="<?= $number_week / $year ?>">
                    </div>
                    <input type="submit" class="submit_style" value="Ajouter">
                </form>
            </div>
        </div>

        <form class="informations" method="post">
            <div class="input_and_label pseudo">
                <input type="username" name="username" id="username" value="<?= $_SESSION['username'] ?>">
                <label for="username" id="label_username">Pseudo</label>
            </div>

            <div class="input_and_label password">
                <input type="password" name="password" id="password" placeholder="Champs vide = aucune modification du mdp">
                <label for="password" id="label_password">Ancien mot de passe</label>
            </div>

            <div class="input_and_label password">
                <input type="password" name="new_password" id="new_password" placeholder="Champs vide = aucune modification du mdp">
                <label for="new_password" id="label_new_password">Nouveau mot de passe</label>
            </div>
            <input type="submit" class="submit_style" name="change_button" value="Modifier">

            <?php if(isset($erreur)) { ?>
                <p class="red align_center"><?=$erreur?></p>
            <?php } ?>
        </form>


        <?php require '../pages/footer.php'; ?>
    </body>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../js/profil.js"></script>
    <script src="../js/popup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="../js/graphic.js"></script>

    </html>

<?php } else {
    header('Location: ../pages/connexion.php');
}


?>