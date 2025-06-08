<?php
include 'header.php';

if (isset($_GET['message'])) {
    $_SESSION['message'] = $_GET['message'];
    header("Refresh:1; url=card.php?title=" . urlencode($_GET['title']));
    exit();
}

$is_admin = false;

if (isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch();

    if ($user && $user['is_admin']) {
        $is_admin = true;
    }
}


if (isset($_GET['title'])) {
    $title = urldecode($_GET['title']);

    // Fetch card from database
    $stmt = $pdo->prepare("SELECT * FROM cards WHERE title = ?");
    $stmt->execute([$title]);
    $card = $stmt->fetch();

    if ($card):
        $card_id = $card['id'];

        // Fetch comments for this card
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE card_id = ? ORDER BY created_at DESC");
        $stmt->execute([$card_id]);
        $comments = $stmt->fetchAll();
?>
<body>
    
<div class="container mt-5">
    <?php if ($card['full_image']) {
    echo '<img class="fullimage" src="' . htmlspecialchars($card['full_image']) . '" alt="Card Full Image" style="max-width: 100%; height: auto; margin-bottom: 20px;">';
}
?>
    <h1><?= htmlspecialchars($card['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($card['content'])) ?></p>

    <a href="index.php" class="btn btn-secondary mb-4">Back to Home</a>

    <hr>
    <h4>Comments</h4>

    <!-- Comment form -->
    <?php if (isset($_SESSION['username'])): ?>
        <form action="submit_comment.php" method="POST">
            <input type="hidden" name="card_id" value="<?= $card_id ?>">
            <input type="hidden" name="title" value="<?= htmlspecialchars($title) ?>">
            <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Write a comment..." required></textarea>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Log in</a> to post a comment.</p>
    <?php endif; ?>

    <hr>
  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>
    <!-- Show comments -->
    <?php foreach ($comments as $comment): ?>
    <div class="card mb-2">
        <div class="card-body">
            <p><?= htmlspecialchars($comment['comment']) ?></p>
            <small class="text-muted">By <?= htmlspecialchars($comment['username']) ?> on <?= $comment['created_at'] ?></small>
           <?php if (isset($_SESSION['username']) && $user['is_admin']): ?>
    <form method="POST" action="delete_comment.php" style="display:inline;">
        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
        <input type="hidden" name="card_title" value="<?= htmlspecialchars($card['title']) ?>">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this comment?')">Delete</button>
    </form>
<?php endif; ?>

        </div>
    </div>
<?php endforeach; ?>
</body>
</html>
<?php
    else:
        echo '<p>Card not found.</p>';
    endif;
} else {
    echo '<p>Invalid request.</p>';
}

?>
<?php
include 'footer.php';
?>