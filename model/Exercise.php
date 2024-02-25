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

    public function insert($idUser, $date, $hour)
    {
        if (isset($_POST['addExercise'], $_POST['addMuscle'], $_POST['addWeight'], $_POST['addRepetition'])) {
            if (!empty($_POST['addExercise']) && !empty($_POST['addMuscle'])) {
                if (preg_match("/\d/", $_POST['addWeight']) === 1) {
                    if (preg_match("/\d/", $_POST['addRepetition']) === 1) {

                        $addExercise = htmlspecialchars($_POST['addExercise']);
                        $addMuscle = htmlspecialchars($_POST['addMuscle']);
                        $addWeight = htmlspecialchars($_POST['addWeight']);
                        $addRepetition = htmlspecialchars($_POST['addRepetition']);

                        $insertExercise = $this->pdo->prepare("INSERT INTO exercise (nom_exercise, user, muscle, poids, repetition, date, hour) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $insertExercise->execute(array($addExercise, $idUser, $addMuscle, $addWeight, $addRepetition, $date, $hour));
                        $lastId = $this->pdo->lastInsertId();
                        echo json_encode(["nom_exercise" => $addExercise, "user" => $idUser, "muscle" => $addMuscle, "poids" => $addWeight, "repetition" => $addRepetition, "date" => $date, "hour" => $hour, "id" => $lastId]);
                    } else {
                        echo json_encode(["error" => 'Le nombre de séries doit être en nombre.']);
                    }
                } else {
                    echo json_encode(["error" => 'Le poids doit être en nombre.']);
                }
            } else {
                echo json_encode(["error" => 'Veuillez remplir toutes les données.']);
            }
        } else {
            echo json_encode(["error" => 'Veuillez remplir toutes les données.']);
        }
    }

    public function recupDaySession($id, $day)
    {
        $recupSession = $this->pdo->prepare("SELECT nom_exercise, user, muscle, poids, repetition, date, hour, id FROM exercise WHERE user=? and date=?  ORDER BY `exercise`.`date` DESC, `exercise`.`hour` DESC"); //Trier par heure puis muscle
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

    public function adminAddMuscleAndExercise($muscle, $exercise)
    {
        $reqAdd = $this->pdo->prepare("INSERT INTO all_muscle (muscle, exercise) VALUES (?, ?)");
        $reqAdd->execute(array($muscle, $exercise));
    }

    public function delete($id)
    {
        $reqDelete = $this->pdo->prepare("DELETE FROM `all_muscle` WHERE id=? ");
        $reqDelete->execute(array($id));
    }
}
