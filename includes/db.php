<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "ylallami", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>