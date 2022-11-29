<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "susim";
$dbPassword = "12345#ghs";
$dbName     = "dbms_project";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// else{
//     echo "You have successfully connected to the database!";
// }
?>