<?php 
    session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Weight.php');

$weight = new Weight;
$allWeight = $weight->fetchAllWeight();

// var_dump($allWeight);

echo json_encode($allWeight);

} else {
    header('Location: ../pages/connexion.php');
}
?>