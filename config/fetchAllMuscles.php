<?php 
    session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Exercise.php');

$exercice = new Exercise;

$fetchAllMuscle = $exercice->recupAllChoiseMuscle();  

echo json_encode($fetchAllMuscle);

} else {
    header('Location: ../pages/connexion.php');
}
?>