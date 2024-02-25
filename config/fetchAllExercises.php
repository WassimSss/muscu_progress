<?php
    session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Exercise.php');

$exercice = new Exercise;

$fetchAllExercises = $exercice->recupAllChoiseExercise();  

echo json_encode($fetchAllExercises);

} else {
    header('Location: ../pages/connexion.php');
}
?>