<?php
include '../src/php/db_connect.php';

// Pagination logic
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch items from the database
$sql = "SELECT * FROM items LIMIT $items_per_page OFFSET $offset";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items - University of San Carlos</title>
    <link rel="stylesheet" href="../src/css/webDesign.css">
</head>
<body>
    <!-- header.php -->
    <?php include '../src/html/dashboard.html'; ?> 

    <div class="container">
        <h2>Found Items</h2>
        
        <!-- Link to Create operation -->
        <div class="create-link">
            <button onclick="openModal('createModal')">Create New Item</button>
        </div>

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
            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="item-card">';
                echo '<img src="../src/assets/images/' . $row['imageLocation'] . '" alt="Item Image">';
                echo '<div class="item-details">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>Date: ' . $row['date_time'] . '</p>';
                echo '<p>Location: ' . $row['location_found'] . '</p>';
                echo '<p>Category: ' . $row['category'] . '</p>';
                echo '<button onclick="openUpdateModal(' . $row['id'] . ')">✏️</button>';
                echo '<button onclick="openDeleteModal(' . $row['id'] . ')">🗑️</button>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Pagination section -->
        <div class="pagination">
            <?php
            // Pagination links
            $sql = "SELECT COUNT(*) AS total FROM items";
            $result = $pdo->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $total_pages = ceil($row['total'] / $items_per_page);

            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='index.php?page={$i}'>{$i}</a> ";
            }
            ?>
        </div>
    </div>

    <!-- Modals -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('createModal')">&times;</span>
            <h2>Create New Item</h2>
            <form id="createForm" enctype="multipart/form-data">
                Date/Time: <input type="datetime-local" name="date_time" required><br>
                Location Found: <input type="text" name="location_found" required><br>
                Category: <input type="text" name="category" required><br>
                Image: <input type="file" name="image" required><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('updateModal')">&times;</span>
            <h2>Update Item</h2>
            <form id="updateForm" enctype="multipart/form-data">
                ID: <input type="text" name="id" id="updateId" readonly><br>
                Date/Time: <input type="datetime-local" name="date_time" id="updateDateTime" required><br>
                Location Found: <input type="text" name="location_found" id="updateLocationFound" required><br>
                Category: <input type="text" name="category" id="updateCategory" required><br>
                Image: <input type="file" name="image"><br>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h2>Delete Item</h2>
            <form id="deleteForm">
                ID: <input type="text" name="id" id="deleteId" readonly><br>
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>

    <script src="../src/assets/script.js"></script>
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function openUpdateModal(id) {
            fetch(`get_item.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('updateId').value = data.id;
                    document.getElementById('updateDateTime').value = data.date_time;
                    document.getElementById('updateLocationFound').value = data.location_found;
                    document.getElementById('updateCategory').value = data.category;
                    openModal('updateModal');
                });
        }

        function openDeleteModal(id) {
            document.getElementById('deleteId').value = id;
            openModal('deleteModal');
        }

        document.getElementById('createForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('create.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(data => {
                  alert(data);
                  closeModal('createModal');
                  location.reload();
              });
        });

        document.getElementById('updateForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('update.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(data => {
                  alert(data);
                  closeModal('updateModal');
                  location.reload();
              });
        });

        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('delete.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(data => {
                  alert(data);
                  closeModal('deleteModal');
                  location.reload();
              });
        });
    </script>
</body>
</html>
