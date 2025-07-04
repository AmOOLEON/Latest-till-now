CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    card_id INT NOT NULL,
    username VARCHAR(255) NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (card_id) REFERENCES cards(id) ON DELETE CASCADE
);
