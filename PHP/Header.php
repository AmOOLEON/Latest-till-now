<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mvp Games</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\\css\\styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    
<?php
session_start();
include 'db.php';

// Check if the user is logged in
$is_logged_in = isset($_SESSION['username']);
$is_admin = false;

if ($is_logged_in) {
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch();

    if ($user && $user['is_admin']) {
        $is_admin = true;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Mvp Games</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            
            <?php if ($is_admin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="control_panel.php">Control Panel</a>
                </li>
            <?php endif; ?>
            <?php if ($is_logged_in): ?>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="signup.php">Sign up</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<?php
if (isset($_SESSION['message'])):
?>
<div class="alert alert-<?= $_SESSION['message'] ?> alert-dismissible fade show text-center alert-bar" role="alert" style = "border : 0.5px solid black ; margin-left: 15%; margin-top: 0.5%; margin-right: 15%; border-radius: 4px; color: black; background-color:rgba(247, 0, 21, 0.09); border-color:rgb(100, 2, 12);">
    <?= htmlspecialchars($_SESSION['message']); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
unset($_SESSION['message']); // Clear the message after displaying it
endif;
?>