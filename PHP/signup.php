<!-- signup.php -->
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Sign Up</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="process_signup.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
