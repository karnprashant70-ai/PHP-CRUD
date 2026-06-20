<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD - Home</title>
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
            padding: 20px;
        }
        
        nav {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        nav a {
            text-decoration: none;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-block;
        }
        
        nav a:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 32px;
        }
        
        p {
            color: #666;
            line-height: 1.8;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">🏠 Home</a></li>
            <li><a href="add_product.php">➕ Add Product</a></li>
            <li><a href="view_products.php">📋 View Products</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h1>Welcome to PHP CRUD System</h1>
        <p>This is a simple CRUD (Create, Read, Update, Delete) application for managing products. Use the navigation menu above to:</p>
        <ul style="margin-top: 20px; margin-left: 30px; color: #666; line-height: 1.8;">
            <li><strong>Add Product:</strong> Create a new product with validation</li>
            <li><strong>View Products:</strong> See all products in the database</li>
        </ul>
    </div>
</body>
</html>