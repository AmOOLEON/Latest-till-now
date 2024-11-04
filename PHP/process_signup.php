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
    echo "Username or email already exists. <a href='signup.php'>Try again</a>";
} else {
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashed_password])) {
        echo "Registration successful. <a href='login.php'>Login</a>";
    } else {
        echo "Error during registration. <a href='signup.php'>Try again</a>";
    }
}
?>
