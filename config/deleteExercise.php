<?php
    session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Exercise.php');   
$exercise = new Exercise;

// créer variable date

$exercise->delete($_GET['id']);

header('Location: ../pages/admin_exercices.php');


} else {
    header('Location: ../pages/connexion.php');
}