<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
    require '../model/Exercise.php';
    $title = 'App';
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/app.css">
        <title><?=$title?></title>
    </head>

    <body>
    <?php require '../pages/navBarApp.php'; ?>

        <div class="all_app">

            <section class="day_session">
                <!-- <p><span class="red">Séance</span> du jour</p> -->

                <div>
                    <form class="form_day_session" method="POST">

                        <div class="label_center">
                            <h2>Entrer un <span class="red">exercice</span></h2>

                            <div class="label_and_select">
                                <label for="choise_muscle">Muscle</label>
                                <?php
                                $exercise = new Exercise;
                                $allMuscle = $exercise->recupAllChoiseMuscle();
                                ?>
                                <select name="muscles" id="choise_muscle">
                                    <option value="" selected="selected">--Choisissez un muscle--</option>
                                    <?php
                                    foreach ($allMuscle as $key => $value) {
                                        $value = $allMuscle[$key]["muscle"];
                                        $nameUnbreakable = preg_replace('/\s+/', '_', $value);/* /\s+/ pour trouver les espaces*/
                                    ?>
                                        <option value=<?= $nameUnbreakable ?>><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="label_and_select">
                                <label for="choise_exercise">Exercice</label>
                                <select name="exercises" id="choise_exercise">
                                    <option value="">--Choisissez un exercice--</option>

                                </select>
                            </div>

                            <div class="input_and_label">
                                <input type="number" name="choise_weight" id="choise_weight">
                                <label for="choise_weight" id="choise_weight">Poids</label>
                                <!-- <ion-icon name="add-outline" class="more_logo" id="add_weight_button"></ion-icon> -->
                            </div>

                            <div class="input_and_label">
                                <input type="number" name="choise_repetition" id="choise_repetition">
                                <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>" id="id_user"> <!-- SECURISER SESSION ID IL PEUT ETRE MODIFIER PAR INSPECTER -->
                                <label for="choise_repetition" id="choise_repetition">Répétitions</label>
                                <!-- <ion-icon name="add-outline" class="more_logo" id="add__repetition_button"></ion-icon> -->
                            </div>

                            <button id="submit_day_session" class="submit_style" value="Ajouter">Ajouter</button>

                        </div>
                    </form>
                </div>

            </section>

            <section class="day_recap">
                <div class="all_contain">
                    <h2><span class="red">Séance</span> du jour</h2>

                    <div class="all_for_muscle">

                    </div>
                </div>
            </section>



            <section class="session_calendar">


                <div class="calendar">

                </div>
            </section>

            <section class="session_in_day">
                <div class="date">
                    <p><span class="red">Séance du </span> <span class="text_date">...</span></p>
                </div>
                <div class="session">
                    <div class="one_muscle">
                        <div class="t_head">

                        </div>
                        <div class="one_exercice_for_muscle">
                            <ul class="all_series">
                                    <p>Veuillez cliquer sur les <span class="red">cases rouges</span> du calendrier pour voir vos séances <span class="red">correspondantes au jour cliqué</span>.</p>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require '../pages/footer.php'; ?>

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="../js/app.js"></script>
    </body>

    </html>



<?php } else {
    echo "Veuillez vous connectez";
}


?>