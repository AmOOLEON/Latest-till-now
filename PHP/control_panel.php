<?php include 'header.php';?>
<?php 
if (isset($_GET['message'])) { 
    $_SESSION['message'] = $_GET['message'];
    header("Refresh:1; url=control_panel.php");
    unset($_GET['message']);
}
?>


<?php



// Redirect non-logged-in users
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

if (!$user || !$user['is_admin']) {
    die("Access Denied: You do not have permission to view this page.");
}
?>


<?php

$imageUploadDir = 'uploads/';


// Check if user is logged in (optional)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM cards WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['message'] = "Card deleted successfully!";
    header("Location: control_panel.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $fullImagePath = null;
if (isset($_FILES['full_image']) && $_FILES['full_image']['error'] === UPLOAD_ERR_OK) {
    $fullImageTmpPath = $_FILES['full_image']['tmp_name'];
    $fullImageName = basename($_FILES['full_image']['name']);
    $fullImagePath = $imageUploadDir . $fullImageName;

    move_uploaded_file($fullImageTmpPath, $fullImagePath);
}

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $imageUploadDir . $imageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Insert the card into the database
            $stmt = $pdo->prepare("INSERT INTO cards (title, description, content, image, full_image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $content, $imagePath, $fullImagePath]);


            $_SESSION['message'] = "Card added successfully!";
        } else {
            $_SESSION['message'] = "Failed to upload image.";
        }
    } else {
        $_SESSION['message'] = "Image upload failed. Please try again.";
    }

    header("Location: control_panel.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $imagePath = $_POST['current_image']; // Default to the existing image
    $fullImagePath = $_POST['current_full_image']; // default
if (isset($_FILES['full_image']) && $_FILES['full_image']['error'] === UPLOAD_ERR_OK) {
    $fullImageTmpPath = $_FILES['full_image']['tmp_name'];
    $fullImageName = basename($_FILES['full_image']['name']);
    $fullImagePath = $imageUploadDir . $fullImageName;

    if(!move_uploaded_file($fullImageTmpPath, $fullImagePath)){
         $_SESSION['message'] = "Failed to upload new Full image.";
    }
}
    // Handle image upload if a new file is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $imageUploadDir . $imageName;

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($imageTmpPath, $imagePath)) {
            $_SESSION['message'] = "Failed to upload new image.";
        }
    }

    // Update the card in the database
    $stmt = $pdo->prepare("UPDATE cards SET title = ?, description = ?, content = ?, image = ?, full_image = ? WHERE id = ?");
    $stmt->execute([$title, $description, $content, $imagePath, $fullImagePath, $id]);

    $_SESSION['message'] = "Card updated successfully!";
    header("Location: control_panel.php");
    exit();
}

// Fetch all cards
$stmt = $pdo->query("SELECT * FROM cards");
$cards = $stmt->fetchAll();
?>



<div class="container mt-5">
        <h1 class="text-center">Control Panel</h1>

        <!-- Display success/error messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Add New Card -->
        <h2>Add New Card</h2>
        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Short Description</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="content">Full Content</label>
                <textarea id="content" name="content" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" class="form-control-file" required>
            </div>
            <div class="form-group">
                <label for="full_image">Full Card Image</label>
                <input type="file" id="full_image" name="full_image" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-success">Add Card</button>
        </form>

        <!-- List of Cards -->
        <h2>Manage Cards</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cards as $card): ?>
                    <tr>
                        <td><?= $card['id']; ?></td>
                        <td><?= htmlspecialchars($card['title']); ?></td>
                        <td><?= htmlspecialchars($card['description']); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?= $card['id']; ?>">Edit</button>

                            <!-- Delete Button -->
                            <a href="?delete_id=<?= $card['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this card?')">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $card['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $card['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $card['id']; ?>">Edit Card</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit">
                                        <input type="hidden" name="id" value="<?= $card['id']; ?>">
                                        <input type="hidden" name="current_image" value="<?= $card['image']; ?>">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($card['title']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Short Description</label>
                                            <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($card['description']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Full Content</label>
                                            <textarea id="content" name="content" class="form-control" required><?= htmlspecialchars($card['content']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" id="image" name="image" class="form-control-file">
                                            <small>Leave empty to keep the current image</small>
                                        </div>
                                        <div class="form-group">
                                         <label for="full_image">Full Card Image</label>
                                        <input type="file" id="full_image" name="full_image" class="form-control-file">
                                        <small>Leave empty to keep current full image</small>
                                        </div>
                                        <input type="hidden" name="current_full_image" value="<?= $card['full_image']; ?>">

                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<script>
function editCard(id, title, description, image) {
    document.getElementById('editCardForm').style.display = 'block';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_content').value = content;
    document.getElementById('edit_image').value = image;
    window.scrollTo(0, document.getElementById('editCardForm').offsetTop);
}
</script>
<?php
include 'db.php';


// Check if the user is logged in and is an admin
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


// Fetch all users
$stmt = $pdo->query("SELECT id, username, email, is_admin FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<body>
    <div class="container mt-5">
        <h1>User Management</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Is Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_user.php?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>



<?php include 'footer.php'; ?>
