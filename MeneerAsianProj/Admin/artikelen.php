<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for adding/updating products
    $name = $_POST['name'];
    $price = $_POST['price'];

    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update existing product
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $price, $_POST['id']]);
    } else {
        // Add new product
        $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
    }
}

// Fetch products for display
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
        <a href="/index.php">Home</a>
        <a href="Admin/beheer_producten.php">Producten Beheren</a>
    </nav>
</header>

<section class="product-management">
    <h2>Product Toevoegen / Bijwerken</h2>
    <form action="Admin/beheer_producten.php" method="post">
        <input type="hidden" name="id" id="product-id">
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Prijs:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <button type="submit">Opslaan</button>
    </form>

    <h2>Producten Lijst</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?php echo htmlspecialchars($product['name']) . " - €" . number_format($product['price'], 2); ?>
                <button onclick="editProduct(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>', <?php echo $product['price']; ?>)">Bewerken</button>
                <button onclick="deleteProduct(<?php echo $product['id']; ?>)">Verwijderen</button>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<script>
function editProduct(id, name, price) {
    document.getElementById('product-id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('price').value = price;
}

function deleteProduct(id) {
    if (confirm('Weet je zeker dat je dit product wilt verwijderen?')) {
        window.location.href = 'Admin/delete_artikelen.php?id=' + id; // Create this file for deletion logic
    }
}
</script>
<a href="Admin/delete_artikelen.php?id=<?php echo $product['id']; ?>">Verwijder</a>
</body>
</html>