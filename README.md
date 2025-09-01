# Login and Register Form

This project provides a simple login and registration form using PHP, HTML, and CSS. It allows users to create new accounts and log in to existing ones. User data is stored in a MySQL database.

## Features and Functionality

*   **User Registration:** Allows new users to create accounts by providing a username and password.
*   **Login:** Authenticates existing users based on their username and password.
*   **Database Integration:** Stores user credentials in a MySQL database for persistent storage.
*   **Role-Based Greeting:** Displays a customized welcome message based on the user's role (Administrator or User) after successful login.
*   **Error Handling:** Provides feedback to the user in case of registration errors (e.g., username already exists) or login failures (e.g., incorrect credentials).
*   **Password Comparison:** Correctly verifies password entered is matching one found in the database.
*   **Popup Messages:** Displays registration success and welcome messages in popup windows.
*   **Basic User Role Management:** The script defaults new users to the role of 'Utilizador', which can be customized.

## Technology Stack

*   **PHP:** Server-side scripting language for handling registration and login logic.
*   **MySQL:** Database for storing user information.
*   **HTML:** Markup language for creating the user interface.
*   **CSS:** Styling language for visual presentation.
*   **JavaScript:** Client-side scripting language for popup functionality.

## Prerequisites

Before running this project, ensure you have the following installed:

*   **PHP:** Version 7.0 or higher.
*   **MySQL:** Database server.
*   **Web Server:** (e.g., Apache, Nginx) to serve the PHP files.

## Installation Instructions

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/JoaoGaspar04/Login-and-Register-Form.git
    cd Login-and-Register-Form
    ```

2.  **Create a MySQL database:**

    Create a new database in your MySQL server.  You can use a tool like phpMyAdmin or the MySQL command-line client. Let's say you name the database `my_database`.

3.  **Create the `Users` table:**

    Execute the following SQL query to create the `Users` table:

    ```sql
    CREATE TABLE Users (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Estado VARCHAR(50) NOT NULL DEFAULT 'Ativo',
        Cargo VARCHAR(50) NOT NULL DEFAULT 'Utilizador'
    );
    ```

4.  **Configure the database connection:**

    Edit the `index.php` file and update the database connection details:

    ```php
    <?php
    // Conexão com o banco de dados
    $servername = "localhost"; // servidor de banco de dados
    $username = "your_mysql_username"; //nome do utilizador
    $password = "your_mysql_password"; // password do utiliador
    $dbname = "my_database"; //nome da base de dados
    $port = 3306; // porta padrão

    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    ?>
    ```

    Replace `"localhost"`, `"your_mysql_username"`, `"your_mysql_password"`, and `"my_database"` with your actual database server address, MySQL username, password, and database name, respectively.  If your MySQL server uses a port other than 3306, adjust the `$port` variable accordingly.

5.  **Place the files in your web server directory:**

    Move the `index.php` file to your web server's document root directory (e.g., `/var/www/html/` for Apache on Linux).

## Usage Guide

1.  **Access the application:**

    Open your web browser and navigate to the URL where you placed the `index.php` file (e.g., `http://localhost/Login-and-Register-Form/index.php` or `http://yourdomain.com/index.php`).

2.  **Register a new user:**

    Fill in the "Registro" form with a username and password, and click "Registrar". If the registration is successful, a popup message will appear.

3.  **Log in:**

    Fill in the "Login" form with your username and password, and click "Entrar". If the login is successful, a welcome message will appear.

## API Documentation

This project does not have a formal API. It is a self-contained web application with a user interface.

## Contributing Guidelines

Contributions are welcome! To contribute to this project:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Commit your changes with descriptive commit messages.
4.  Push your branch to your forked repository.
5.  Create a pull request to the `main` branch of the original repository.

## License Information

No license is specified for this project.  All rights are reserved by the author.

## Contact/Support Information

For questions or support, please contact [JoaoGaspar04](https://github.com/JoaoGaspar04) through GitHub.