<?php
// Include database connection
include 'db_connect.php';

// Initialize variables
$errors = [];
$success = false;
$product_name = $description = $price = $quantity = $category = $image_url = $status = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get form data
    $product_name = trim($_POST['product_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $status = trim($_POST['status'] ?? 'active');
    
    // Validation
    if (empty($product_name)) {
        $errors[] = "Product name is required!";
    } elseif (strlen($product_name) < 3) {
        $errors[] = "Product name must be at least 3 characters!";
    }
    
    if (empty($price)) {
        $errors[] = "Price is required!";
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors[] = "Price must be a valid positive number!";
    }
    
    if (empty($quantity)) {
        $errors[] = "Quantity is required!";
    } elseif (!is_numeric($quantity) || $quantity < 0 || intval($quantity) != $quantity) {
        $errors[] = "Quantity must be a valid positive integer!";
    }
    
    if (empty($category)) {
        $errors[] = "Category is required!";
    }
    
    if (!empty($image_url) && !filter_var($image_url, FILTER_VALIDATE_URL)) {
        $errors[] = "Please enter a valid image URL!";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO products (product_name, description, price, quantity, category, image_url, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            // types: s=string, d=double, i=int -> product_name(s), description(s), price(d), quantity(i), category(s), image_url(s), status(s)
            $stmt->bind_param("ssdisss", $product_name, $description, $price, $quantity, $category, $image_url, $status);
            
            if ($stmt->execute()) {
                $success = true;
                // Reset form fields
                $product_name = $description = $price = $quantity = $category = $image_url = '';
                $status = 'active';
            } else {
                $errors[] = "Error inserting product: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .error-list {
            margin-left: 20px;
        }
        
        .error-list li {
            margin-bottom: 8px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="number"],
        input[type="url"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="url"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .required {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Product</h1>
        
        <?php if ($success): ?>
            <div class="success-message">
                ✓ Product added successfully!
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <strong>Please fix the following errors:</strong>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" novalidate>
            <div class="form-group">
                <label for="product_name">Product Name <span class="required">*</span></label>
                <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="price">Price <span class="required">*</span></label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity <span class="required">*</span></label>
                <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="category">Category <span class="required">*</span></label>
                <select id="category" name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Electronics" <?php echo $category === 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                    <option value="Clothing" <?php echo $category === 'Clothing' ? 'selected' : ''; ?>>Clothing</option>
                    <option value="Books" <?php echo $category === 'Books' ? 'selected' : ''; ?>>Books</option>
                    <option value="Food" <?php echo $category === 'Food' ? 'selected' : ''; ?>>Food</option>
                    <option value="Other" <?php echo $category === 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image_url">Image URL</label>
                <input type="url" id="image_url" name="image_url" value="<?php echo htmlspecialchars($image_url); ?>" placeholder="https://example.com/image.jpg">
            </div>
            
            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
