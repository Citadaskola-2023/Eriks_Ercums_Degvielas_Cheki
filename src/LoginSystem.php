<?php

namespace App;

class LoginSystem
{
    private array $users = [
        'user1' => '$2y$10$qVh9obuAK38mU5pz0uNi5.hlNVC9AV/wF76rKjdOeQ1kSkOv7qLWS', // Hashed password for '0000'
    ];

    public function login(string $username, string $password): bool {
        if (array_key_exists($username, $this->users)) {
            if (password_verify($password, $this->users[$username])) {
                session_start();
                $_SESSION['username'] = $username;
                return true;
            }
        }
        return false;
    }

    public function isLoggedIn(): void {
        session_start();
        if(!isset($_SESSION['username']))
        {
            $this->logout();
            exit;
        }
    }

    public function logout(): void {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();

        ob_start();
        header("Location: /?");
        ob_end_flush();
        exit;
    }
}
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    $login = new \App\LoginSystem();
    $login->logout();
}