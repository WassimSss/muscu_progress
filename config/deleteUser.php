<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email']) && $_SESSION['role_admin'] == 1) {
    require_once('../model/User.php');   
$user = new User;

// créer variable date

$user->delete($_GET['id']);

header('Location: ../pages/admin_users.php');
} else {
    header('Location: ../pages/connexion.php');
}

