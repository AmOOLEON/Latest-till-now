CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique user ID
    username VARCHAR(50) NOT NULL UNIQUE, -- Username of the user
    email VARCHAR(100) NOT NULL UNIQUE, -- User's email
    password VARCHAR(255) NOT NULL, -- Hashed password
    is_admin BOOLEAN NOT NULL DEFAULT 0, -- Admin flag (0 = regular user, 1 = admin)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Account creation timestamp
);
