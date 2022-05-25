<?php
require_once '../config/Bdd.php';

class Weight {
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Bdd::importBdd();
    }

    public function insert(){
        $date = date('d.m.Y'); 
        $good_format= strtotime($date);
        $number_week = date('W',$good_format);
        $year = date('Y');
        
        $selectDate = $this->pdo->prepare("SELECT all_date FROM weight WHERE user = ? and all_date = ?");
        $selectDate->execute(array($_SESSION['id'], $date));

        $ifWeightInDate = $selectDate->rowCount();

        if(!$ifWeightInDate >= 1){
            $insertWeight = $this->pdo->prepare("INSERT INTO weight (user, weight,  week_and_year, all_date) VALUES (?,?,?, ?)");
            $insertWeight->execute(array($_SESSION['id'], $_GET['week_weight'], "$number_week/$year", $date));
        } else {
            $insertWeight = $this->pdo->prepare("UPDATE weight set weight = ? WHERE user = ? and all_date = ?");
            $insertWeight->execute(array($_GET['week_weight'], $_SESSION['id'], $date));
        }
    }

    public function fetchAllWeight(){
        $selectWeight = $this->pdo->prepare("SELECT weight, all_date FROM weight WHERE user = ? ORDER BY `weight`.`all_date` ASC");
        $selectWeight->execute(array($_SESSION['id']));

        $fetchAllWeight = $selectWeight->fetchAll();
        return $fetchAllWeight;

    }

}