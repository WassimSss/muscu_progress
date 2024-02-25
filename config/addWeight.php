<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {

require_once('../model/Weight.php');
$weight = new Weight;
var_dump($_GET);
$weight->insert();

header('Location: ../pages/profil.php');

} else {
    header('Location: ../pages/connexion.php');
}