<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email']) && $_SESSION['role_admin'] == 1) {
    require '../model/Exercise.php'

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/admin.css">
        <title>Admin</title>
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
                    <li><a class="link_signup no_active" href="profil.php">Profil</a></li>
                    <?php if ($_SESSION['role_admin'] == 1) { ?>
                        <li><a class="active_link" href="admin.php">Admin</a></li>
                    <?php } ?>
                </div>

                <div class="nav_right">
                    <li><a href="deconnexion.php">Deconnexion</a></li>
                </div>
            </ul>
        </nav>

        <table>
            <thead>
                <tr>
                    <th colspan="2">The table header</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>The table body</td>
                    <td>with two columns</td>
                </tr>
            </tbody>
        </table>


    </body>

    </html>

<?php } ?>