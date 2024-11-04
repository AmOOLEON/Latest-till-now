<!-- process_signup.php -->
<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect if already logged in
    exit();
}
?>

<?php
/*include 'db.php';

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
}*/
?>
<!-- process_signup.php -->
<?php
// Placeholder code for demonstration
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// You would typically save this data to a database after hashing the password
// Example (please replace with actual database code):
// $hashed_password = password_hash($password, PASSWORD_BCRYPT);
// Database insertion code goes here

echo "Registration successful. <a href='login.php'>Login</a>";
?>

