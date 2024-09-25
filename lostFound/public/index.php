<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items - University of San Carlos</title>
    <link rel="stylesheet" href="../css/webdesign.css">
</head>
<body>
    <!-- header.php -->
    <?php include '../html/dashboard.html'; ?> 

    <div class="container">
        <h2>Found Items</h2>
        
        <!-- Search and filter section -->
        <div class="search-filter">
            <input type="text" id="search" placeholder="Search...">
            <button onclick="searchItems()">Search</button>

            <select id="categoryFilter" onchange="filterByCategory()">
                <option value="">Search by Category</option>
                <option value="Tumbler">Tumbler</option>
                <option value="Electronics">Electronics</option>
                <option value="Clothing">Clothing</option>
                <option value="Jewelry">Jewelry</option>
                <option value="Keys & Keychain">Keys & Keychain</option>
            </select>
        </div>

        <!-- Found items grid -->
        <div class="items-grid">
            <!-- Placeholder for dynamic content -->
            <div class="item-card">
                <img src="../assets/images/salamanders.jpeg" alt="Item Image">
                <div class="item-details">
                    <h3>Aqua Flask Gradient</h3>
                    <p>Date: 07/08/2024</p>
                    <p>Location: Bunzel Canteen</p>
                    <p>Category: Tumbler</p>
                </div>
            </div>

            <!-- Add similar blocks for other items -->
        </div>

        <!-- Pagination section -->
        <div class="pagination">
            <span class="active">1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
        </div>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>
