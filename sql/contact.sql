CREATE DATABASE IF NOT EXISTS testTask;
CREATE TABLE IF NOT EXISTS contact(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sourceID    int(11) NOT NULL,
    phone       bigint(10) NOT NULL,
    name        varchar(127) NOT NULL,
    email       varchar(255) NOT NULL,
    createTS    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    /* PRIMARY KEY (`id`), */
    UNIQUE KEY `sourceID_phone` (`sourceID`,`phone`)
);
