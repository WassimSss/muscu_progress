<?php

if (isset($_SESSION['username']) && isset($_SESSION['email']) && $_SESSION['role_admin'] == 1) {

require_once '../model/Exercise.php';
$exercise = new Exercise;

if (isset($_POST['submit_add_exercise'])) {
    if (isset($_POST['input_muscle']) && isset($_POST['input_exercise'])) {
        $postMuscle = htmlspecialchars($_POST['input_muscle']);
        $postExercise = htmlspecialchars($_POST['input_exercise']);
        if (preg_match("/[À-ÿ0-9!-?]/", $postMuscle) == 0 && preg_match("/[À-ÿ0-9!-?]/", $postExercise) == 0) // Si on ne trouve pas de chiffres, caractères spéciaux ou accents
        {
            $reqAdd = $exercise->adminAddMuscleAndExercise($postMuscle, $postExercise);
            header('Location: ../pages/admin_exercices.php');
        } else {
            $erreur = "Veuillez entrer des valeurs valides (Seulement des lettres sans caractère spécial et sans accent)";
            var_dump(preg_match("/[À-ÿ0-9!-?]/", $postExercise));
        }
    } else {
        $erreur = "Veuillez entrer un muscle et un exercice";
    }
}

} else {
    header('Location: ../pages/connexion.php');
}