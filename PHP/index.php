<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mvp Games</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mvp Games</a>
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
        <h1 class="text-center">Welcome</h1>
        <p class="text-center">Your free Game server hosting solution.</p>

        <div class="text-center mb-4">
            <form method="POST" action="">
                <input type="number" name="cardCount" placeholder="Enter number of squares" min="1" max="21" class="form-control d-inline-block" style="width: 200px;" required>
                <button type="submit" class="btn btn-primary">Generate Cards</button>
            </form>
        </div>

        <div id="features" class="row">
            <?php
            // Define an array of features
           

            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $count = intval($_POST['cardCount']);
                //$count = max(1, min($count, 10)); // Ensure count is between 1 and 10

                // Generate cards based on user input
                for ($i = 0; $i < $count; $i++) {
                    $t=$i+1;
                    $features[] = [
                        "title" => "Feature " . $t,
                        "description" => "Description of feature " . $t . ".",
                        "image" => "https://via.placeholder.com/150?text=Feature+" . $t // Example image with text
                    ];
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
        <p>&copy; 2024 Mvp games. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>