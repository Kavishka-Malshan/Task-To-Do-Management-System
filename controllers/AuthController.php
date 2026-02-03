<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../includes/Validator.php';

class AuthController {
    private $userModel;
    private $validator;

    public function __construct($mysqli) {
        $this->userModel = new User($mysqli);
        $this->validator = new Validator();
    }

    public function register() {
        if (isPost()) {
            $username = getPost('username');
            $email = getPost('email');
            $password = getPost('password');
            $password_confirm = getPost('password_confirm');

            $this->validator->validateUsername($username);
            $this->validator->validateEmail($email);
            $this->validator->validatePassword($password);

            if ($password !== $password_confirm) {
                $this->validator->addError('password_confirm', 'Passwords do not match');
            }

            if ($this->userModel->usernameExists($username)) {
                $this->validator->addError('username', 'Username already exists');
            }

            if ($this->userModel->userExists($email)) {
                $this->validator->addError('email', 'Email already registered');
            }

            if (!$this->validator->hasErrors()) {
                if ($this->userModel->register($username, $email, $password)) {
                    setFlash('success', 'Registration successful. Please login.');
                    redirect('?action=login');
                } else {
                    $this->validator->addError('general', 'Registration failed. Please try again.');
                }
            }
        }

        return [
            'errors' => $this->validator->getErrors(),
            'csrf_token' => generateCsrfToken()
        ];
    }

    public function login() {
        if (isPost()) {
            $email = getPost('email');
            $password = getPost('password');

            if (!verifyCsrfToken(getPost('csrf_token'))) {
                $this->validator->addError('general', 'Invalid security token');
            } else {
                if ($this->userModel->login($email, $password)) {
                    Session::set('user_id', $this->userModel->getId());
                    Session::set('username', $this->userModel->getUsername());
                    setFlash('success', 'Login successful');
                    redirect('?action=tasks');
                } else {
                    $this->validator->addError('general', 'Invalid email or password');
                }
            }
        }

        return [
            'errors' => $this->validator->getErrors(),
            'csrf_token' => generateCsrfToken()
        ];
    }

    public function logout() {
        Session::destroy();
        setFlash('success', 'Logged out successfully');
        redirect('?action=login');
    }
}

?>
