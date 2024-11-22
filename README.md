# DGL_123_Group6_PROJECT

## DGL123 - INTRODUCTION TO PHP

## Team Members

- Tien Pham - n0210614
- Himanshu Punia - n0207198
- Varunkanth - n0205489

# Project Documentation

---

## Overview

This project is a dynamic e-commerce website for an online clothing store, enabling users to browse and shop for curated collections. It integrates a back-end in PHP with MySQL for data management and ensures a responsive front-end for optimal user experience.

## Main Features
- Homepage: A visually appealing homepage featuring the latest products and categories.
- Product Catalog: A detailed list of clothing items with filters by category, size, and price.
- User Authentication: Secure login and registration system for customers.
- Shopping Cart: Add, update, or remove items in the cart before checkout.
- Order Management: View order history and track the status of current orders.
- Accessibility Features: Designed to meet accessibility standards using WAVE and Lighthouse tools.
  
## Features

1. ## User Authentication System
   - Registration and Login:
     - register.php handles user registration.
     - login.php manages user login.
     - Passwords are hashed using password_hash() for security.
   - Logout:
     - logout.php securely ends user sessions.
2. ## Product Management
   - Product Display:
     - product.php dynamically loads product details from the database.
   - Shopping Functionality:
     - shopping.php allows users to view and purchase available products.
     - cart.php implements a shopping cart to store selected items.
3. ## Database Integration

   - Database Configuration:
     - db.php connects the application to the MySQL database.
     - Data such as user credentials, product details, and orders are stored.

   - CRUD Operations:
     - Products, users, and cart data can be created, updated, and deleted using PHP scripts.

4. ## Dynamic Front-End
   - Homepage:
     - index.php serves as the homepage, welcoming users and linking to the shopping page.
   - Header and Footer Components:
     - includes/header.php and includes/footer.php ensure a consistent layout.
5. ## Navigation
   - A clear navigation bar links to essential pages like:
     - Home
     - Shopping
     - Login/Register
6. ## Responsive Design

   - CSS Styling:
     - style.css and styles.css ensure a visually appealing, mobile-friendly design.

   - Core Files and Directories
     - Root Files:
     - index.php (Homepage)
     - README.md (Documentation overview)
     - Includes Directory:
       - Header and footer components for reusability.
     - Database Schema:
       - Includes tables for:
         - Users (id, username, password)
         - Products (id, name, price, description)
         - Orders (id, user_id, product_id, quantity)

## Technologies Used

   - Back-End: PHP (handles dynamic content and database interactions).
   - Database: MySQL.
   - Front-End: HTML, CSS, JavaScript.
   - Server Environment: XAMPP (for local testing).

## Security Features

   - Password hashing with password_hash() for safe storage.
   - Input sanitization to prevent SQL injection.
   - Secure session handling for user authentication.

## How to Set Up the Project Locally
### Prerequisites
- PHP (v8.0 or higher)
- MySQL (v5.7 or higher)
- A local server environment like XAMPP, WAMP, or MAMP
- A web browser
  
### Steps to Install and Run the Project
1. Clone the Repository to your local 

2. Set Up the Database

- Import the provided demophp.sql file into the MySQL server. *[OR]*
- Alternatively, use phpMyAdmin to import the demophp.sql file.
  
3. Configure the Environment

- Edit the config.php file to include the database credentials (can be found in db.php)

<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '""');
define('DB_NAME', 'demophp');
?>

4. Start the Local Server

- Using XAMPP/WAMP/MAMP, move the project folder to the htdocs directory.
- Open the local server (http://localhost/<project_folder>)
- Run the Application

## Future Improvements

   - Add payment gateway integration.
   - Include advanced filters for products.
   - Enable order tracking for users.
     
## Contributors
Tien: Backend Development and Databae setup

Varunkath: Database setup and project documentation

Himanshu Punia: Frontend Development, User Authentication
