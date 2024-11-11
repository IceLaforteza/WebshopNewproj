<?php
include 'Include/db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    // Validate input
    if (!empty($name) && is_numeric($price) && $price >= 0) {
        $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
        header("Location: beheer_producten.php?message=Product%20toegevoegd");
        exit();
    } else {
        $error = "Ongeldige invoer. Zorg ervoor dat de naam niet leeg is en de prijs een geldig getal is.";
    }
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
        <div class="message">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Prijs</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>€<?php echo number_format($product['price'], 2, ',', '.'); ?></td>
                    <td>
                        <a href="beheer_producten.php?action=delete&id=<?php echo $product['id']; ?>" onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">Verwijder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Voeg een nieuw product toe</h3>
    <form method="POST" action="beheer_producten.php">
        <label for="name">Productnaam:</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Prijs:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <button type="submit" name="add_product">Toevoegen</button>
    </form>
</section>

</body>
</html>