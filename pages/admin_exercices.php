<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email']) && $_SESSION['role_admin'] == 1) {
    $title = "Admin";

    require '../model/Exercise.php';
    $exercise = new Exercise;

    $allExercices = $exercise->allExercisesNumber();
    if (isset($_GET['exercise']) && !empty($_GET['exercise'] && $_GET['exercise'] > 20)) {
        $exercisePerPage = $_GET['exercise'];
    } else {
        $exercisePerPage = 20;
    }


    $pagesTotales = ceil($allExercices / $exercisePerPage);

    if (isset($_GET['page']) && !empty($_GET['page'] && $_GET['page'] > 0 && $_GET['page'] <= $pagesTotales)) {
        $_GET['page'] = intval($_GET['page']);
        $pageCourante = $_GET['page'];
    } else {
        $pageCourante = 1;
    }

    $depart = ($pageCourante - 1) * $exercisePerPage;

    require '../config/adminAddMuscle.php';
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/admin.css">
        <title><?= $title ?> - Exercices</title>
    </head>

    <body>
        <?php require '../pages/navBarApp.php'; ?>

        <div class="link_admin">
            <a href="../pages/admin_users.php">Utilisateurs</a>
            <a href="../pages/admin_exercices.php">Exercices</a>
        </div>

        <div class="setting">
            <form action="" method="GET">
            <label for="exercise_per_page">Nombre d'exercice par page</label>

                <select name="exercise" id="exercise_per_page">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                </select>

                <input type="submit">
            </form>
            


        </div>

        <table id="table_users">
            <thead>
                <tr>
                    <!--<th>Id</th>-->
                    <th>Muscle</th>
                    <th>Exercice</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($exercise->fetchAllExercises($depart, $exercisePerPage) as $key) { ?>
                    <tr>
                        <!--<td><?= $key['id'] ?></td>-->
                        <td><?= $key['muscle'] ?></td>
                        <td><?= $key['exercise'] ?></td>
                        <td><a href="../config/deleteExercise.php?id=<?= $key['id'] ?>" onclick="Supp(this.href); return(false);">
                                <ion-icon name="trash-outline"></ion-icon>
                            </a></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            for ($i = 1; $i <= $pagesTotales; $i++) { ?>
                <a <?php
                    if ($i == $pageCourante) { ?> class="active" <?php } ?> href="admin_exercices.php?page=<?= $i ?>&exercise=<?= $exercisePerPage ?>"><?= $i ?></a>
            <?php } ?>
        </div>

        <div class="form_add">
            <form method="POST">
                <input type="text" name="input_muscle" placeholder="Muscle">
                <input type="text" name="input_exercise" placeholder="Exercice">
                <input type="submit" value="Ajouter" name="submit_add_exercise">
            </form>
            <?php if (isset($erreur)) {
                echo '<p class="red">' . $erreur . '</p>';
            } ?>
        </div>

        <?php require '../pages/footer.php'; ?>

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="../js/admin.js"></script>
    </body>

    </html>

<?php } else {
    header('Location: ../pages/connexion.php');
} ?>