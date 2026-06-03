create database IF NOT EXISTS TestDatabase;

use TestDatabase;

CREATE TABLE IF NOT EXISTS Users (
user_ID INT NOT NULL AUTO_INCREMENT,
username VARCHAR(50) NOT NULL UNIQUE,
hash_Password VARCHAR(255) NOT NULL,
email VARCHAR(50) NOT NULL UNIQUE,
PRIMARY KEY (user_ID)
) Engine = InnoDB;

CREATE TABLE IF NOT EXISTS Contacts(
contact_ID INT NOT NULL AUTO_INCREMENT,
first_name VARCHAR(50) NOT NULL,
last_name VARCHAR(50) NOT NULL,
email VARCHAR(50) DEFAULT NULL,
phone VARCHAR(50) DEFAULT NULL,
address VARCHAR(100) NOT NULL,
user_ID INT,
PRIMARY KEY (contact_ID),
CONSTRAINT fk_Contacts_User
FOREIGN KEY (user_ID) REFERENCES Users(user_ID)
ON DELETE CASCADE
ON UPDATE CASCADE
) Engine = InnoDB;

INSERT INTO Users (
username, email, hash_password
)
VALUES (
'MikeL',
'MikeLanstin@gmail.com',
'%2y#9&$o*!e4h7Mike'
),
(
'AprilW',
'AprilWinster@gmail.com',
'%2y#9&$o*!e4h7April'
),
(
'PeterY',
'PeterYullin@gmail.com',
'%2y#9&$o*!e4h7Peter'
);

INSERT INTO Contacts (
first_name, last_name, email, phone, address, user_ID
)
VALUES (
'Reese',
'Phern',
'ReesePhern@gmail.com',
'1234567890',
'123RockStreet',
'1'
),

(
'Michelle',
'Ficcus',
'MichelleFiccus@gmail.com',
'9876543210',
'321PebbleRoad',
'1'
),

(
'Katie',
'Plaid',
'KatiePlaid@gmail.com',
'1842843078',
'839MountAvenue',
'2'
),

(
'Oliver',
'Jackson',
'OliverJackson@gmail.com',
'1029384756',
'456BoulderWay',
'3'
);














