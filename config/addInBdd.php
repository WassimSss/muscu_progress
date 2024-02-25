<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Exercise.php');   

$exercice = new Exercise;
date_default_timezone_set('Europe/Amsterdam');
$date = date('d.m.Y'); 
$hour = date("H.i.s");

// créer variable date
$idUser = $_SESSION['id'];
$exercice->insert($idUser, $date, $hour);
} else {
    header('Location: ../pages/connexion.php');
}


