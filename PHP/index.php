<?php include 'Header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Welcome</h1>
        <p class="text-center">Your free Game server hosting solution.</p>

        

        <div id="features" class="row">
    <?php
 // Fetch cards from the database
$stmt = $pdo->query("SELECT id, title, description, image FROM cards");
$cards = $stmt->fetchAll();

foreach ($cards as $card) {
    $titleSlug = urlencode($card['title']); // Encode title for URL
    echo '
    <div class="col-md-4">
        <div class="card">
            <img src="' . $card['image'] . '" class="card-img-top" alt="' . htmlspecialchars($card['title']) . '">
            <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($card['title']) . '</h5>
                <p class="card-text">' . htmlspecialchars($card['description']) . '</p>
                <a href="card.php?title=' . $titleSlug . '" class="btn btn-primary">Read More...</a>
            </div>
        </div>
    </div>';
}
?>
    
</div>

    </div>

<?php include 'Footer.php'; ?>