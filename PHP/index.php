<?php include 'Header.php'; ?>
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
           $count = 3;

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

<?php include 'Footer.php'; ?>