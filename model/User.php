<?php
require_once '../config/Bdd.php';


class User {
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Bdd::importBdd();
    }

    public function allUsersNumber(){
        $selectUsers = $this->pdo->query("SELECT id FROM membres");
        $numberUsers = $selectUsers->rowCount();

        return $numberUsers;
    }
    
    public function fetchAllUsers($start, $perPage){
        $selectUsers = $this->pdo->prepare("SELECT id, username, email, role_admin FROM membres ORDER BY `membres`.`id` ASC LIMIT $start, $perPage");
        $selectUsers->execute();

        $fetchUsers = $selectUsers->fetchAll();
        return $fetchUsers;
    }

    public function delete($id){
        $reqDelete = $this->pdo->prepare("DELETE FROM `membres` WHERE id=? ");
        $reqDelete->execute(array($id));
    }

    
}

