<?php
include 'header.php';
require_once 'db.php'; // Include database connection

if (isset($_GET['title'])) {
    $title = urldecode($_GET['title']); // Decode title from URL

    // Fetch the card from the database
    $stmt = $pdo->prepare("SELECT * FROM cards WHERE title = ?");
    $stmt->execute([$title]);
    $card = $stmt->fetch();

    if ($card) {
        echo '
        <body>
            <div class="container mt-5">
                <h1>' . htmlspecialchars($card['title']) . '</h1>
                <p>' . htmlspecialchars($card['content']) . '</p>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </div>
        </body>
        </html>';
    } else {
        echo '<p>Card not found.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}
include 'footer.php';
?>
