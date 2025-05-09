CREATE TABLE users(
    id int(11) AUTO_INCREMENT PRIMARY KEY not null,
    username VARCHAR(30) not null,
    pwd VARCHAR(255) not null,
    email VARCHAR(100) not null,
    create_at DATETIME NOT NULL DEFAULT CURRENT_TIME
);