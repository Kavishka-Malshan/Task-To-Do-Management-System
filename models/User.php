<?php

class User {
    private $mysqli;
    private $id;
    private $username;
    private $email;
    private $password_hash;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function register($username, $email, $password) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->mysqli->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("sss", $username, $email, $password_hash);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function login($email, $password) {
        $stmt = $this->mysqli->prepare("SELECT id, username, email, password_hash FROM users WHERE email = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }

        $user = $result->fetch_assoc();
        $stmt->close();

        if (password_verify($password, $user['password_hash'])) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            return true;
        }

        return false;
    }

    public function userExists($email) {
        $stmt = $this->mysqli->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    public function usernameExists($username) {
        $stmt = $this->mysqli->prepare("SELECT id FROM users WHERE username = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
}

?>
