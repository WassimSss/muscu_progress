<?php 
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
require_once('../model/Exercise.php');

//Recuperer toute les sessions du jours

$exercice = new Exercise;
// créer variable date
// Rajouter un input avec name=id 
date_default_timezone_set('Europe/Amsterdam');
$date = date('d.m.Y'); 
$idUser = $_SESSION['id'];
$fetchExercice = $exercice->recupDaySession($idUser, $date);  

echo json_encode($fetchExercice);

} else {
    header('Location: ../pages/connexion.php');
}