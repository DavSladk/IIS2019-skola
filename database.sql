CREATE TABLE IF NOT EXISTS users (
    userId int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    role varchar(14) NOT NULL,
    PRIMARY KEY(userId)
);

CREATE TABLE IF NOT EXISTS courses (
    courseId int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description varchar(1023) NOT NULL,
    type varchar(255) NOT NULL,
    tags varchar(255) NOT NULL,
    price int NOT NULL,
    approved boolean NOT NULL DEFAULT 0,
    userId int NOT NULL, #Guarantor
    PRIMARY KEY(courseId),
    FOREIGN KEY(userId) REFERENCES users(userId)
);

CREATE TABLE IF NOT EXISTS lectors (
    lectorId int NOT NULL AUTO_INCREMENT,
    userId int NOT NULL,
    courseId int NOT NULL,
    PRIMARY KEY(lectorId),
    FOREIGN KEY(userId) REFERENCES users(userId),
    FOREIGN KEY(courseId) REFERENCES courses(courseId)
);

CREATE TABLE IF NOT EXISTS terms (
    termId int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description varchar(1023) NOT NULL,
    type varchar(255) NOT NULL,
    score int NOT NULL,
    datetime DATETIME NOT NULL,
    courseId int NOT NULL,
    PRIMARY KEY(termId),
    FOREIGN KEY(courseId) REFERENCES courses(courseId)
);

CREATE TABLE IF NOT EXISTS files (
    fileId varchar(255) NOT NULL,
    termId int NOT NULL,
    PRIMARY KEY(fileId),
    FOREIGN KEY(termId) REFERENCES terms(termId) 
);

CREATE TABLE IF NOT EXISTS rooms (
    roomId int NOT NULL AUTO_INCREMENT,
    address varchar(255) NOT NULL,
    doorNumber varchar(255) NOT NULL,
    type varchar(255) NOT NULL,
    capacity int NOT NULL,
    PRIMARY KEY(roomId)
);

CREATE TABLE IF NOT EXISTS termsRooms (
    termRoomId int NOT NULL AUTO_INCREMENT,
    termId int NOT NULL,
    roomId int NOT NULL,
    PRIMARY KEY(termRoomId),
    FOREIGN KEY(termId) REFERENCES terms(termId),
    FOREIGN KEY(roomId) REFERENCES rooms(roomId) 
);

CREATE TABLE IF NOT EXISTS registred (
    registredId int NOT NULL AUTO_INCREMENT,
    approved boolean NOT NULL DEFAULT 0,
    score int DEFAULT 0,
    userId int NOT NULL,
    courseId int NOT NULL,
    PRIMARY KEY(registredId),
    FOREIGN KEY(userId) REFERENCES users(userId),
    FOREIGN KEY(courseId) REFERENCES courses(courseId),
    CONSTRAINT CHK_score CHECK(score BETWEEN 0 AND 100)
);