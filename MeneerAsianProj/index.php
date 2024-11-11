<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportwinkel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- <button onclick="addToCart('<?php echo addslashes($product['name']); ?>', 
<?php echo $product['price']; ?>)">Voeg toe aan winkelwagentje</button> -->

<header>
    <h1>Sportwinkel</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="admin/manage_products.php">Beheer Producten</a>
        <a href="#" id="cart-link">Winkelwagen (<span id="cart-count">0</span>)</a>
    </nav>
</header>

<section class="products">
    <?php
    include 'includes/db.php';
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product) {
        echo '<div class="product">';
        echo '<h2>' . htmlspecialchars($product['name']) . '</h2>';
        echo '<p>Prijs: €' . number_format($product['price'], 2) . '</p>';
        echo '<button onclick="addToCart(\'' . addslashes($product['name']) . '\', ' . $product['price'] . ')">Voeg toe aan winkelwagentje</button>';
        echo '</div>';
    }
    ?>
</section>

<div id="cart-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Winkelwagen</h2>
        <ul id="cart-items"></ul>
        <p>Totaal: €<span id="total-price">0.00</span></p>
        <button id="checkoutButton" class="checkout-button">Afrekenen</button>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>