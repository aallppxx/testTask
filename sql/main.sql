CREATE DATABASE testTask IF NOT EXIST;
CREATE TABLE IF NOT EXIST client(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName   varchar(150) NOT NULL,
    lastName    varchar(150) NOT NULL,
    mobilePhone varchar(10) NOT NULL,
    desc        TEXT,
    createTS    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
