<?php

namespace App;
use PDO;
use PDOException;
class DB
{
    public function connectDB() : PDO{
        try{
            return new \PDO(
                'mysql:host=mysql;dbname=myapp;',
                'root',
                'root',
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        }
        catch (PDOException $e){
            echo $e->getCode() . " " . $e->getMessage() . '<br>';
            die("Shit went tits up...");
        }
    }
    public function login(string $username, string $password) : void{
        if($username === 'user1' && $password === '0000'){
            header("Location: /receipt");
            exit;
        }
        else{
            echo "<h3> WRONG USERNAME OR PASSWORD";
        }
    }
}