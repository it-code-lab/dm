<?php
// includes/db.php




$host = 'localhost';
$db   = 'digital_marketing_agency';
$user = 'admin';
$pass = 'admin';
$charset = 'utf8mb4';
$port = '3306';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// $options = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];

// try {
//      $conn = new PDO($dsn, $user, $pass, $options);
// } catch (\PDOException $e) {
//      die('Database connection failed: ' . $e->getMessage());
// }

$mysqli = new mysqli($host, $user, $pass, $db, $port);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
$conn = $mysqli;
// Set the character set to utf8mb4
$conn->set_charset($charset);

?>
