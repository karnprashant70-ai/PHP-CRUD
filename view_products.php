<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>View Products</title>
    <style>
        body{font-family: Arial,Helvetica,sans-serif;background:#f4f6f8;padding:20px}
        .container{max-width:1000px;margin:0 auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
        table{width:100%;border-collapse:collapse}
        th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
        th{background:#fafafa}
        .actions{display:flex;gap:8px}
        a.btn{display:inline-block;padding:8px 12px;background:#667eea;color:#fff;border-radius:5px;text-decoration:none}
        a.btn-edit{background:#48bb78}
        a.btn-delete{background:#f56565}
    </style>
</head>
<body>
    <div class="container">
        <h1>Products</h1>
        <p><a class="btn" href="index.php">Back</a> <a class="btn" href="add_product.php">Add Product</a></p>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td>Rs. <?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Update</a>
                                    <a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['product_name']); ?>')" class="btn btn-delete">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script>
        function confirmDelete(id, productName) {
            if (confirm(`Are you sure you want to delete "${productName}"?\n\nThis action cannot be undone.`)) {
                window.location.href = 'delete_product.php?id=' + id;
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>