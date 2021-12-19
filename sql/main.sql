CREATE DATABASE IF NOT EXISTS testTask;
CREATE TABLE IF NOT EXISTS client(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName   varchar(150) NOT NULL,
    lastName    varchar(150) NOT NULL,
    mobilePhone varchar(16) NOT NULL,
    comment     TEXT DEFAULT NULL,
    createTS    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
