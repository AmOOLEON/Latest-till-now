<!-- process_login.php -->
<?php
/*session_start();
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
    echo "Invalid username or password. <a href='login.php'>Try again</a>";
}*/
?>
<!-- process_login.php -->
<?php
session_start();

// Placeholder code for demonstration
$username = $_POST['username'];
$password = $_POST['password'];

// Replace this with database verification
if ($username === 'user' && $password === 'pass') {
    $_SESSION['username'] = $username;
    header("Location: index.php"); // Redirect to home page after login
} else {
    echo "Invalid credentials. <a href='login.php'>Try again</a>";
}
?>
