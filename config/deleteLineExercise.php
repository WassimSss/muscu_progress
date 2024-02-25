<?php 
    session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Exercise.php');

//Recuperer toute les sessions du jours

$exercice = new Exercise;
$deleteExercise = $exercice->deleteDayExercice();  

} else {
    header('Location: ../pages/connexion.php');
}