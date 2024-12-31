<!-- process_login.php -->
<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect if already logged in
    exit();
}
?>

<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Retrieve the user from the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Password is correct, start a session
    $_SESSION['username'] = $user['username'];
    header("Location: index.php"); // Redirect to home page after login
    exit();
} else {
    $_SESSION['message'] = 'Invalid username or pasword try again!'; // success message
    header("Location: login.php");
}
?>

