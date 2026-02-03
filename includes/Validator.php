<?php

class Validator {
    private $errors = [];

    public function validateEmail($email) {
        if (empty($email)) {
            $this->errors['email'] = 'Email is required';
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Invalid email format';
            return false;
        }
        return true;
    }

    public function validatePassword($password) {
        if (empty($password)) {
            $this->errors['password'] = 'Password is required';
            return false;
        }
        if (strlen($password) < 6) {
            $this->errors['password'] = 'Password must be at least 6 characters';
            return false;
        }
        return true;
    }

    public function validateUsername($username) {
        if (empty($username)) {
            $this->errors['username'] = 'Username is required';
            return false;
        }
        if (strlen($username) < 3) {
            $this->errors['username'] = 'Username must be at least 3 characters';
            return false;
        }
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $this->errors['username'] = 'Username can only contain letters, numbers, hyphens and underscores';
            return false;
        }
        return true;
    }

    public function validateTaskTitle($title) {
        if (empty($title)) {
            $this->errors['title'] = 'Task title is required';
            return false;
        }
        if (strlen($title) > 255) {
            $this->errors['title'] = 'Task title cannot exceed 255 characters';
            return false;
        }
        return true;
    }

    public function validateTodoText($text) {
        if (empty($text)) {
            $this->errors['text'] = 'Todo text is required';
            return false;
        }
        if (strlen($text) > 500) {
            $this->errors['text'] = 'Todo text cannot exceed 500 characters';
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function addError($key, $message) {
        $this->errors[$key] = $message;
    }

    public function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

?>
