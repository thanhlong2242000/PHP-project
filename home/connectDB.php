<?php
$servername = "localhost";
$username = "root";
$password = "123456";
try {
  $conn = new PDO("mysql:host=$servername;dbname=ymner", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>