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




// Check if user is logged in (optional)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM cards WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['message'] = "Card deleted successfully";
    header("Location: control_panel.php");
    exit();
}

// Handle add card request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_card'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $stmt = $pdo->prepare("INSERT INTO cards (title, description, image) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $image]);
    $_SESSION['message'] = "Card added successfully";
    header("Location: control_panel.php");
    exit();
}

// Handle edit card request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_card'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $stmt = $pdo->prepare("UPDATE cards SET title = ?, description = ?, image = ? WHERE id = ?");
    $stmt->execute([$title, $description, $image, $id]);
    $_SESSION['message'] = "Card updated successfully";
    header("Location: control_panel.php");
    exit();
}

// Fetch all cards
$stmt = $pdo->query("SELECT * FROM cards");
$cards = $stmt->fetchAll();
?>



<div class="container mt-5">
    <h2>Control Panel</h2>

    <!-- Add Card Form -->
    <h4>Add New Card</h4>
    <form method="POST" class="mb-5">
        <input type="hidden" name="add_card" value="1">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" id="image" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Add Card</button>
    </form>

    <!-- Cards Table -->
    <h4>Manage Cards</h4>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cards as $card): ?>
            <tr>
                <td><?php echo $card['id']; ?></td>
                <td><?php echo htmlspecialchars($card['title']); ?></td>
                <td><?php echo htmlspecialchars($card['description']); ?></td>
                <td><img src="<?php echo htmlspecialchars($card['image']); ?>" alt="Image" style="width: 100px;"></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editCard(<?php echo $card['id']; ?>, '<?php echo htmlspecialchars($card['title']); ?>', '<?php echo htmlspecialchars($card['description']); ?>', '<?php echo htmlspecialchars($card['image']); ?>')">Edit</button>
                    <a href="control_panel.php?delete=<?php echo $card['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Edit Card Form -->
    <div id="editCardForm" class="mt-5" style="display: none;">
        <h4>Edit Card</h4>
        <form method="POST">
            <input type="hidden" name="edit_card" value="1">
            <input type="hidden" id="edit_id" name="id">
            <div class="form-group">
                <label for="edit_title">Title</label>
                <input type="text" id="edit_title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_description">Description</label>
                <textarea id="edit_description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="edit_image">Image URL</label>
                <input type="text" id="edit_image" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<script>
function editCard(id, title, description, image) {
    document.getElementById('editCardForm').style.display = 'block';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = description;
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
