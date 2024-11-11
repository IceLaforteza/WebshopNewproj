<?php
include '../includes/db.php';

// Handle product deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    header("Location: manage_products.php?message=Product%20verwijderd");
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
    header("Location: manage_products.php?message=Product%20toegevoegd");
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
    <?php if (isset($_GET['message'])): ?>
        <p><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Naam</th>
                <th>Prijs</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>€<?php echo number_format($product['price'], 2); ?></td>
                    <td>
                        <a href="manage_products.php?action=delete&id=<?php echo $product['id']; ?>">Verwijder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Voeg een nieuw product toe</h2>
    <form method="POST" action="manage_products.php">
        <label for="name">Productnaam:</label>
        <input type="text" name="name" required>
        <label for="price">Prijs:</label>
        <input type="number" name="price" step="0.01" required>
        <button type="submit" name="add_product">Voeg toe</button>
    </form>
</section>

</body>
</html>