<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    try {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $productId);
        $stmt->execute();

        // Redirect back to the manage products page after deletion
        header("Location: manage_products.php?message=Product%20verwijderd");
        exit();
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
} else {
    echo "Geen product ID opgegeven.";
}
?>