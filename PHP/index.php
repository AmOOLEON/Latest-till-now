<?php include 'Header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Welcome</h1>
        <p class="text-center">Your free Game server hosting solution.</p>

        

        <div id="features" class="row">
    <?php
    include 'db.php';

    // Fetch cards from the database
    $stmt = $pdo->query("SELECT * FROM cards");
    while ($row = $stmt->fetch()) {
        echo '
        <div class="col-md-4">
            <div class="card">
                <img src="' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                    <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
                </div>
            </div>
        </div>';
    }
    ?>
</div>

    </div>

<?php include 'Footer.php'; ?>