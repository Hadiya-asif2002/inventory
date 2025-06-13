CREATE DATABASE inventory_management;
USE  inventory_management;
CREATE TABLE departments(
   id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
   name  VARCHAR(50) UNIQUE NOT NULL,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE employees(
    id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
    userid INT,
    name VARCHAR(50),
    designation  VARCHAR(30),
    reports_to VARCHAR(50),
    department_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

CREATE TABLE inventory_items(
    id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
    name VARCHAR(50) NOT NULL ,
    value VARCHAR(50),
    category VARCHAR(50),
    subcategory VARCHAR(50),
    quantity VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE assigned_inventory(
    id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
    employee_id INT,
    item VARCHAR(30),
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
    username VARCHAR(30),
    email VARCHAR(50) NOT NULL,
    email_verified_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(255),
    expires_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL 1 DAY),
    forgot_password_token VARCHAR(255),
    password_reset_token VARCHAR(255),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

