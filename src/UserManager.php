<?php

namespace App;

require __DIR__ . '/../src/DB.php';
class UserManager
{
    private function userInputCheck(string $username, string $password) : bool{
        if(empty($username)){
            echo "Empty username input field.";
            return false;
        }
        if(empty($password)){
            echo "Empty password input field.";
            return false;
        }
        return true;
    }
    public function signup(string $username, string $password) : bool
    {
        if(!$this->userInputCheck($username, $password)){
            die();
        }
        $DB = new DB();
        $conn = $DB->connectDB();

        $stmt = $conn->prepare("SELECT username FROM Users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if(empty($stmt->fetchAll())){
            $stmt = $conn->prepare("INSERT INTO Users(username, password)
            VALUES(:username, :password)");

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);;
            $stmt->execute();
            return true;
        }
        return false;
    }

    public function login(string $username, string $password) : bool
    {
        if(!$this->userInputCheck($username, $password)){
            die();
        }

        $DB = new DB();
        $conn = $DB->connectDB();

        $stmt = $conn->prepare("SELECT username FROM Users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if(!empty($stmt->fetchAll())){
            return true;
        }
        return false;
    }
}