<?php
$host = 'localhost';  // Database host
$dbname = 'hw_db';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password

try {
    // Create PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    return 'Connection failed: ' . $e->getMessage();
}


$query = "SELECT item_desc FROM item_description";
$stmt = $pdo->query($query);

// Fetch all data and return as JSON
$data = $stmt->fetchAll();
echo json_encode($data);

?>