<?php include('../src/assets/header.php'); ?>

<div class="dashboard-container">
    <div class="item-grid">
        <?php
        // Sample database connection and query
        include('db_connect.php');
        $result = mysqli_query($conn, "SELECT * FROM found_items");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='item-card'>
                <img src='" . $row['image'] . "' alt='" . $row['name'] . "' class='item-img'>
                <div class='item-details'>
                    <h3>" . $row['name'] . "</h3>
                    <p>Date: " . $row['date_found'] . "</p>
                    <p>Location: " . $row['location'] . "</p>
                    <p>Category: " . $row['category'] . "</p>
                    <button class='view-btn' data-id='" . $row['id'] . "'>View Details</button>
                </div>
            </div>
            ";
        }
        ?>
    </div>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <span id="close-modal" class="close">&times;</span>
        <h2 id="modal-title"></h2>
        <div id="modal-body"></div>
    </div>
</div>

<?php include('../src/assets/footer.php');

?>