<?php
session_start();
require_once('../model/User.php');   
$user = new User;

// créer variable date

$user->delete($_GET['id']);

header('Location: ../pages/admin.php');