<?php

define('DB_HOST', '127.0.0.1'); // Changed from 'localhost' to '127.0.0.1'
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'todo_management');
define('DB_PORT', 3307); // Define the custom port

// Added DB_PORT as the 5th argument
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");

// Optional: Echo success for testing (remove this after it works)
// echo "Connected successfully to " . DB_NAME;

?>