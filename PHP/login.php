<!-- login.php -->
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Login</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="process_login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign up here</a>.</p>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
