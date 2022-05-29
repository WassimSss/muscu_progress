<?php

$bddObject = new Bdd;
    $bdd = $bddObject->importBdd();
    if (isset($_POST['change_button'])) {
        if (!empty($_POST['username'])) {
            $username = htmlspecialchars($_POST['username']);

            if (preg_match("/^[a-zA-Z]{4,20}+$/", $username) === 1) {
                $reqChangeUsername = $bdd->prepare("UPDATE membres SET username=? WHERE id=?");
                $reqChangeUsername = $reqChangeUsername->execute(array($username, $_SESSION['id']));
                $_SESSION['username'] = $username;
            } else {
                $erreur = "Votre pseudo doit contenir entre 4 et 20 lettres seulement";
            }
        }
        if (!empty($_POST['password']) && !empty($_POST['new_password'])) {
            $password = sha1($_POST['password']);
            $newPassword = sha1($_POST['new_password']);

            if (preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.).{6,20}$/", $_POST['password'])) //Entre 6 & 20 minuscule maj chiffre obligation [a-zA-Z0-9]
            {
                $recupLastPassword = $bdd->prepare("SELECT password FROM membres WHERE id=?");
                $recupLastPassword->execute(array($_SESSION['id']));
                
                $dumptest = "Avant hashage : " . $_POST['password'] . " Après hashage :" . " $password ";
                $dumptest2 = "Avant hashage : " . $_POST['new_password'] . " Après hashage :" . " $newPassword ";

                $fetchLastPassword = $recupLastPassword->fetch();
                
                if ($password === $fetchLastPassword['password']) {
                    $reqChangePassword = $bdd->prepare("UPDATE membres SET password=? WHERE id=?");
                    $reqChangePassword->execute(array($newPassword, $_SESSION['id']));
                } else {
                    $erreur = "Mot de passe non identique à l'ancien";
                }
            } else {
                $erreur = "Votre mot de passe doit être compris entre 6 et 20  caractère avec majuscule, minuscule et chiffre";
            }
        }
    }