<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Unauthorized.");
}

$card_id = $_POST['card_id'];
$comment = trim($_POST['comment']);
$username = $_SESSION['username'];
$title = $_POST['title']; // get the card title for redirection

if ($comment !== '') {
    $stmt = $pdo->prepare("INSERT INTO comments (card_id, username, comment) VALUES (?, ?, ?)");
    $stmt->execute([$card_id, $username, $comment]);
}

header("Location: card.php?title=" . urlencode($title));
exit();
