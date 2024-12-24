<?php include 'header.php'; ?>
<?php
include 'db.php';
//session_start();

// Redirect non-admin users
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

if (!$user || !$user['is_admin']) {
    die("Access Denied: You do not have permission to view this page.");
}

// Handle user update
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE id = ?");
    $stmt->execute([$username, $email, $is_admin, $id]);

    header("Location: control_panel.php");
    exit();
}

// Fetch user data for editing
$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT id, username, email, is_admin FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}
?>


<body>
    <div class="container mt-5">
        <h1>Edit User</h1>
        <form method="POST" action="edit_user.php">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="is_admin" class="form-check-input" <?= $user['is_admin'] ? 'checked' : '' ?>>
                <label class="form-check-label">Is Admin</label>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update User</button>
        </form>
    </div>
</body>
</html>
<?php include 'footer.php'; ?>
