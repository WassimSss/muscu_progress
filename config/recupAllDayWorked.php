
<?php
    session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Exercise.php');

$exercice = new Exercise;

$fetchAllDayWorked = $exercice->recupAllDayWorkForUser();  

echo json_encode($fetchAllDayWorked);

} else {
    header('Location: ../pages/connexion.php');
}

?>