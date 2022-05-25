<?php
session_start();
require_once('../model/Weight.php');
$weight = new Weight;
var_dump($_GET);
$weight->insert();

header('Location: ../pages/profil.php');
