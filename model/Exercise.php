<?php

// if (!$bddDesactivated) {
require_once '../config/Bdd.php';
// }


class Exercise
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Bdd::importBdd();
    }

    public function insert($date, $hour)
    {
        $insertExercise = $this->pdo->prepare("INSERT INTO exercise (nom_exercise, user, muscle, poids, repetition, date, hour) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertExercise->execute(array($_POST['addExercise'], $_SESSION['id'], $_POST['addMuscle'], $_POST['addWeight'], $_POST['addRepetition'], $date, $hour)); 
        $lastId = $this->pdo->lastInsertId();
        echo json_encode(["nom_exercise" => $_POST['addExercise'], "user" => $_SESSION['id'], "muscle" => $_POST['addMuscle'], "poids" => $_POST['addWeight'], "repetition" => $_POST['addRepetition'], "date" => $date, "hour" => $hour, "id" => $lastId]);
    }

    public function recupDaySession($id, $day)
    {
        $recupSession = $this->pdo->prepare("SELECT nom_exercise, user, muscle, poids, repetition, date, hour, id FROM exercise WHERE user=? and date=?  ORDER BY `exercise`.`date` DESC, `exercise`.`hour` DESC"); //trier par heure puis muscle aucun changement dans le rafraichissement
        $recupSession->execute(array($id, $day));
        $fetchRecupSession = $recupSession->fetchAll();
        return $fetchRecupSession;
    }

    public function recupDayMuscleTitle()
    {
        $recupMuscleTitle = $this->pdo->prepare("SELECT muscle FROM exercise WHERE user=? and date=?");
        $recupMuscleTitle->execute(array($_SESSION['id'], $this->today));
        $fetchRecupMuscleTitle = $recupMuscleTitle->fetchAll();
        return $fetchRecupMuscleTitle;
    }

    public function recupAllChoiseMuscle()
    {
        $recupAllMuscle = $this->pdo->prepare("SELECT COUNT(*) AS nbr_double, muscle FROM all_muscle GROUP BY muscle HAVING COUNT(*) >= 1 ORDER BY `all_muscle`.`muscle` ASC");
        $recupAllMuscle->execute();
        $fetchRecupAllMuscle = $recupAllMuscle->fetchAll();
        return $fetchRecupAllMuscle;
    }

    public function allExercisesNumber()
    {
        $selectExercises = $this->pdo->query("SELECT id FROM all_muscle");
        $numberExercises = $selectExercises->rowCount();

        return $numberExercises;
    }

    // public function recupallUniqueMuscleEnter($id, $day){
    //     $recupallUniqueMuscleEnter = $this->pdo->prepare("SELECT COUNT(*) AS nbr_doublon, muscle FROM exercise where user = ? and date = ? GROUP BY muscle HAVING COUNT(*) > 1; ");
    //     $recupallUniqueMuscleEnter->execute(array($id, $day)); 
    //     $fetchRecupallUniqueMuscleEnter = $recupallUniqueMuscleEnter->fetchAll();
    //     return $fetchRecupallUniqueMuscleEnter;
    // }

    public function recupDayExerciseTitle()
    {
        $recupMuscleTitle = $this->pdo->prepare("SELECT muscle FROM exercise WHERE user=? and date=?");
        $recupMuscleTitle->execute(array($_SESSION['id'], $this->today));
        $fetchRecupMuscleTitle = $recupMuscleTitle->fetchAll();
        return $fetchRecupMuscleTitle;
    }

    public function recupAllDayWorkForUser()
    {
        $recupDaysWorked = $this->pdo->prepare("SELECT COUNT(*) AS nbr_double, date FROM exercise WHERE user=? GROUP BY date HAVING COUNT(*) > 1 ");
        $recupDaysWorked->execute(array($_SESSION['id']));
        $fetchRecupDaysWorked = $recupDaysWorked->fetchAll();
        return $fetchRecupDaysWorked;
    }

    public function deleteDayExercice()
    {
        $deleteDayExercise = $this->pdo->prepare("DELETE FROM exercise WHERE id=?");
        $deleteDayExercise->execute(array($_POST['classId']));
        echo json_encode(["classId" => $_POST['classId']]);
    }

    public function fetchAllExercises($start, $perPage)
    {
        $selectExercises = $this->pdo->prepare("SELECT id, muscle, exercise FROM all_muscle ORDER BY `all_muscle`.`muscle` ASC LIMIT $start, $perPage");
        $selectExercises->execute();

        $fetchExercises = $selectExercises->fetchAll();
        return $fetchExercises;
    }

    public function recupAllChoiseExercise()
    {
        $recupAllExercise = $this->pdo->prepare("SELECT muscle, exercise, id FROM all_muscle ORDER BY `all_muscle`.`muscle` ASC, `all_muscle`.`exercise` ASC");
        $recupAllExercise->execute();
        $fetchRecupAllExercise = $recupAllExercise->fetchAll();
        return $fetchRecupAllExercise;
    }

    public function adminAddMuscleAndExercise($muscle, $exercise){
        $reqAdd = $this->pdo->prepare("INSERT INTO all_muscle (muscle, exercise) VALUES (?, ?)");
        $reqAdd->execute(array($muscle, $exercise));
    }

    public function delete($id)
    {
        $reqDelete = $this->pdo->prepare("DELETE FROM `all_muscle` WHERE id=? ");
        $reqDelete->execute(array($id));
    }
}
