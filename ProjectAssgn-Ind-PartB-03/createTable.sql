CREATE TABLE users(
    users_id int(11) AUTO_INCREMENT PRIMARY KEY not null,
    users_uid TINYTEXT not null,
    users_pwd LONGTEXT not null,
    users_email TINYTEXT not null
);

CREATE TABLE profiles (
    profiles_id int NOT NULL AUTO_INCREMENT,
    profiles_about TEXT NOT NULL,
    profiles_introtitle TEXT NOT NULL,
    profiles_introtext TEXT NOT NULL,
    users_id int,
    PRIMARY KEY(profiles_id),
    FOREIGN KEY(users_id) REFERENCES users(users_id)
);