<?php
session_start();
require_once('../model/Exercise.php');   
$exercice = new Exercise;
date_default_timezone_set('Europe/Amsterdam');
$date = date('d.m.Y'); 
$hour = date("H.i.s");
// créer variable date
$exercice->insert($date, $hour);
$_SESSION['id'] = $_POST['id'];
// var_dump(array($_POST['addExercise'], $_SESSION['id'], $_POST['addMuscle'], $_POST['addWeight'], $_POST['addRepetition'], $date, $hour));


// // Rajouter un input avec name=id 
// $fetchExercice = $exercice->recupDaySession($_POST['id'], '03.03.22');  

// echo json_encode($fetchExercice);

?>


