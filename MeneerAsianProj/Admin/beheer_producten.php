<?php
include '../includes/db.php';

// Handle product deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    header("Location: beheer_producten.php?message=Product%20verwijderd");
    exit();
}

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
    header("Location: beheer_producten.php?message=Product%20toegevoegd");
    exit();
}

// Fetch all products
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Beheer Producten</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header>
    <h1>Beheer Producten</h1>
    <nav>
        <a href="../index.php">Home</a>
    </nav>
</header>

<section class="product-management">
    <h2>Producten</h2>