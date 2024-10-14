<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aternos-like Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Aternos Clone</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Welcome to Aternos Clone</h1>
        <p class="text-center">Your free Minecraft server hosting solution.</p>

        <div class="text-center mb-4">
            <form method="POST" action="">
                <input type="number" name="cardCount" placeholder="Enter number of squares" min="1" max="10" class="form-control d-inline-block" style="width: 200px;" required>
                <button type="submit" class="btn btn-primary">Generate Cards</button>
            </form>
        </div>

        <div id="features" class="row">
            <?php
            // Define an array of features
            $features = [
                ["title" => "Feature 1", "description" => "Description of feature 1.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 2", "description" => "Description of feature 2.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 3", "description" => "Description of feature 3.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 4", "description" => "Description of feature 4.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 5", "description" => "Description of feature 5.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 6", "description" => "Description of feature 6.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 7", "description" => "Description of feature 7.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 8", "description" => "Description of feature 8.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 9", "description" => "Description of feature 9.", "image" => "https://via.placeholder.com/150"],
                ["title" => "Feature 10", "description" => "Description of feature 10.", "image" => "https://via.placeholder.com/150"],
            ];

            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $count = intval($_POST['cardCount']);
                $count = max(1, min($count, 10)); // Ensure count is between 1 and 10

                // Generate cards based on user input
                for ($i = 0; $i < $count; $i++) {
                    if (isset($features[$i])) {
                        echo '
                        <div class="col-md-4">
                            <div class="card">
                                <img src="' . $features[$i]['image'] . '" class="card-img-top" alt="' . $features[$i]['title'] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $features[$i]['title'] . '</h5>
                                    <p class="card-text">' . $features[$i]['description'] . '</p>
                                </div>
                            </div>
                        </div>';
                    }
                }
            }
            ?>
        </div>
    </div>

    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 Aternos Clone. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>