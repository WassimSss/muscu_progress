<?php
session_start();
require_once('../model/Exercise.php');

$exercice = new Exercise;

$fetchAllExerciseInDay = $exercice->recupDaySession($_SESSION['id'],$_GET['test']);  

// var_dump($fetchAllExerciseInDay);

echo json_encode($fetchAllExerciseInDay);
?>