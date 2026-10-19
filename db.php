<?php
$host = "sql312.infinityfree.com";
$dbname = "if0_43210361_inventory_db";
$user = "if0_43210361";
$password = "8YHjz3UqXO2";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>