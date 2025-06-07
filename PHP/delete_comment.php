<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
    die("Unauthorized.");
}

$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

if (!$user || !$user['is_admin']) {
    die("Access Denied.");
}

if (isset($_POST['comment_id']) && isset($_POST['card_title'])) {
    $comment_id = $_POST['comment_id'];
    $card_title = $_POST['card_title'];

    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);

    // Redirect back to the same card with a message
    $redirect = "card.php?title=" . urlencode($card_title) . "&message=" . urlencode("Comment deleted successfully!");
    header("Location: $redirect");
    exit();
} else {
    echo "Invalid request.";
}
