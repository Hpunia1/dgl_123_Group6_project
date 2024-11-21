# DGL_123_Group6_PROJECT

DGL123 - INTRODUCTION TO PHP
------------------------------------------------------------------------------------------------------------------------------------------------------------------

Team Members
------------
 * Tien Pham - n0210614
 * Himanshu Punia - n0207198
 * Varunkanth - n0205489


 Project Documentation
 ---------------------

Overview
--------
This project is a dynamic e-commerce website for an online clothing store, enabling users to browse and shop for curated collections. It integrates a back-end in PHP with MySQL for data management and ensures a responsive front-end for optimal user experience.

Features
--------

1. User Authentication System
   --------------------------
    * Registration and Login:
       *register.php handles user registration.
       *login.php manages user login.
       *Passwords are hashed using password_hash() for security.
    * Logout:
       *logout.php securely ends user sessions.
   
2. Product Management
   ------------------
    * Product Display:
        *product.php dynamically loads product details from the database.
    * Shopping Functionality:
        *shopping.php allows users to view and purchase available products.
        *cart.php implements a shopping cart to store selected items.
   
3. Database Integration
   --------------------
   
   * Database Configuration:
        *db.php connects the application to the MySQL database.
        *Data such as user credentials, product details, and orders are stored.
   
   * CRUD Operations:
        *Products, users, and cart data can be created, updated, and deleted using PHP scripts.
   
4. Dynamic Front-End
   -----------------
   * Homepage:
       *index.php serves as the homepage, welcoming users and linking to the shopping page.
   * Header and Footer Components:
        *includes/header.php and includes/footer.php ensure a consistent layout.
   
5. Navigation
   ----------
   * A clear navigation bar links to essential pages like:
        *Home
        *Shopping
        *Login/Register

   
6. Responsive Design
   -----------------
   
   * CSS Styling:
        *style.css and styles.css ensure a visually appealing, mobile-friendly design.
   
   * Core Files and Directories
       *Root Files:
          *index.php (Homepage)
          *router.php (Handles routing)
          *README.md (Documentation overview)
       *Includes Directory:
          *Header and footer components for reusability.
       *Scripts Directory:
          *Contains JavaScript or auxiliary scripts (if applicable).
       *Database Schema:
          *Includes tables for:
             *Users (id, username, password)
             *Products (id, name, price, description)
             *Orders (id, user_id, product_id, quantity)
   
   Technologies Used
   -----------------

     * Back-End: PHP (handles dynamic content and database interactions).
     * Database: MySQL.
     * Front-End: HTML, CSS, JavaScript.
     * Server Environment: XAMPP (for local testing).
  
   Security Features
   -----------------

     * Password hashing with password_hash() for safe storage.
     * Input sanitization to prevent SQL injection.
     * Secure session handling for user authentication.
  
    Installation and Setup
    ----------------------

     * Install XAMPP or another PHP environment.
     * Clone the project into the htdocs directory.
     * Import the provided SQL file into MySQL to create the database.
     * Update db.php with your database credentials.
     * Start the Apache and MySQL servers in XAMPP.
     * Access the project at http://localhost/<project_folder>.
  
    Future Improvements
     -------------------

     * Add payment gateway integration.
     * Include advanced filters for products.
     * Enable order tracking for users.
  
-------------------------------------------------------------------------------------------------------------------------------------------------------------------
