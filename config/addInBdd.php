<?php
session_start();
require_once('../model/Exercise.php');   

$exercice = new Exercise;
date_default_timezone_set('Europe/Amsterdam');
$date = date('d.m.Y'); 
$hour = date("H.i.s");

// créer variable date
var_dump($_POST);
$exercice->insert($date, $hour);
$_SESSION['id'] = $_POST['id'];

// echo json_encode($exercice);
?>


