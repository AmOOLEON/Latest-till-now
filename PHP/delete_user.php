<?php
// Include the database connection
require_once 'db.php'; // Ensure this points to your database connection file

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']); // Sanitize input

    try {
        // Prepare the delete query
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$delete_id]);

        // Redirect back to the control panel
        header("Location: control_panel.php?message=User deleted successfully");
        exit();
    } catch (PDOException $e) {
        // Redirect back with an error message
        header("Location: control_panel.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect back if no delete ID is provided
    header("Location: control_panel.php?error=Invalid request");
    exit();
}
