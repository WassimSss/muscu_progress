<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Exercise.php');

$exercice = new Exercise;

$fetchAllExerciseInDay = $exercice->recupDaySession($_SESSION['id'],$_GET['day']);  

echo json_encode($fetchAllExerciseInDay);

} else {
    header('Location: ../pages/connexion.php');
}

