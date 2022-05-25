<?php
require '../config/bddConnexion.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="../css/inscription.css">-->
    <link rel="stylesheet" href="../css/connexion.css">
    <title>MuscuProgress - Connexion</title>
</head>
<body>
    <nav class="nav_signin nav_form">
        <ul>
            <div class="nav_left">
                <li><a href="../index.php"><img class="img_logo" src="../image/dumbbell.png"></a></li>
                <li><a href="../index.php">MuscuProgress</a></li>
            </div>

            <div class="nav_right">
                <li><a class="active_link" href="connexion.php">Connexion</a></li>   
                <li><a class="no_active" href="inscription.php">Inscription</a></li>
            </div>
        </ul>
    </nav>

    <section class="section_before_form signin_form">
        <div class="section_before_form_title">
            <h2>Se connecter<span class="red">.</span></h2>      
            <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscription</a></p>
        </div>

        <form class="form_signup_and_signin signin_form" method="post">
                <div class="input_and_label signin_div">
                    <input type="email" name="email" id="email" <?php
                    if (isset($_SESSION["email_user"])) { ?>
                        value="<?= $_SESSION['email_user']?>"
                    <?php } ?>
                    >
                    <label for="email" id="label_email">Email</label>
                </div>
            
            <div class="input_and_label signin_div">
                <input type="password" name="password" id="password">
                <label for="password" id="label_confirm_password">Mot de passe</label>
            </div>

            <div class="submit_div">
                <input type="submit" name="submit_signin" id="submit_signin" class="submit_style" value="Connexion">
            </div>
            
        </form>
    </section>
    <?php if(isset($erreur)){echo $erreur;} ?>
</body>
</html>