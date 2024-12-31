<!-- process_signup.php -->
<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect if already logged in
    exit();
}
?>

<?php
include 'db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if username or email already exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->execute([$username, $email]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['message'] = 'Username or Email already exists try again'; // Error message
    header("Location: signup.php");
} else {
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashed_password])) {
        $_SESSION['message'] = 'Registration successful!'; // success message
    header("Location: login.php");
    } else {
        $_SESSION['message'] = 'Error during registeration'; // Error message
    header("Location: signup.php");
    }
}
?>
