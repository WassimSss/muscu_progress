<?php 
session_start();
require_once('../model/Weight.php');

$weight = new Weight;
$allWeight = $weight->fetchAllWeight();

// var_dump($allWeight);

echo json_encode($allWeight);
?>