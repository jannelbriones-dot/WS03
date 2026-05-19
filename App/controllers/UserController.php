<?php

namespace App\Controllers;

use framework\Database;
use framework\Validation;
use framework\Session;

class UserController {
    protected Database $db;

    public function __construct() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show register page
     */
    public function create($params = []) {
        loadView('users/create');
    }

    /**
     * Show login page
     */
    public function login($params = []) {
        loadView('users/login');
    }

    /**
     * Store user to database
     */
    public function store($params = []) {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/auth/register');
            return;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $city = $_POST['city'] ?? '';
        $state = $_POST['state'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirmation = $_POST['password_confirmation'] ?? '';

        $errors = [];

        // Validate email
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Validate name
        if (!Validation::string($name, 2, 50)) {
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        // Validate password
        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        // Validate password confirmation
        if (!Validation::match($password, $passwordConfirmation)) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        // If validation errors, return to form
        if (!empty($errors)) {
            loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state
                ]
            ]);
            return;
        }

        // Check if email already exists
        $existingUser = $this->db->query(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        )->fetch();

        if ($existingUser) {
            $errors['email'] = 'That email already exists';
            loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state
                ]
            ]);
            return;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $this->db->query(
            "INSERT INTO users (name, email, city, state, password)
            VALUES (:name, :email, :city, :state, :password)",
            [
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'state' => $state,
                'password' => $hashedPassword
            ]
        );

        // Get the last insert ID using the PDO connection directly
        $userid = $this->db->conn->lastInsertId();
        // Set user session
        Session::set('user',[
            'id' => $userid,
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state
        ]);

        
        redirect('/');
    }

    /**
     * Authenticate user with email and password
     */
    public function authenticate() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/auth/login');
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $errors = [];

        // Validate email
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Validate password
        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        if (!empty($errors)) {
            loadView('Users/login', [
                'errors' => $errors,
                'email' => $email
            ]);
            return;
        }

        // Check if email exists
        $user = $this->db->query(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        )->fetch();

        if (!$user) {
            $errors['email'] = 'Incorrect credentials';
            loadView('Users/login', [
                'errors' => $errors,
                'email' => $email
            ]);
            return;
        }

        // Verify password
        if (!password_verify($password, $user->password)) {
            $errors['email'] = 'Incorrect credentials';
            loadView('users/login', [
                'errors' => $errors,
                'email' => $email
            ]);
            return;
        }

        // Set user session
        Session::set('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'state' => $user->state
        ]);

        
        redirect('/');
    }

    /**
     * Logout user and kill session
     */
    public function logout($params = []) {
        // Unset all session variables
        $_SESSION = [];
        
        // Destroy the session
        session_destroy();
        
        // Remove session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        redirect('/');
    }
}