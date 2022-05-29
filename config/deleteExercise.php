<?php
session_start();
require_once('../model/Exercise.php');   
$exercise = new Exercise;

// créer variable date

$exercise->delete($_GET['id']);

header('Location: ../pages/admin_exercices.php');