<?php
include 'db_connect.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Error: No product ID provided.";
    exit;
}

$id = intval($_GET['id']);

// Delete the product from database
$sql = "DELETE FROM products WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_products.php?success=1");
    exit;
} else {
    echo "Error deleting product: " . $conn->error;
}

$conn->close();
?>
