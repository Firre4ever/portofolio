<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "portofolio";

$conn = new mysqli($servername, $username, $password, $db_name);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST["name"];
    $input_password = $_POST["password"];

    // Debugging: Print input username
    echo "Debug: Input Username - $input_username<br>";

    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_username);

        $param_username = $input_username;

        if ($stmt->execute()) {
            $stmt->store_result();

            // Debugging: Print number of rows found
            echo "Debug: Number of rows found - " . $stmt->num_rows . "<br>";

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username, $hashed_password);

                if ($stmt->fetch()) {
                    if (password_verify($input_password, $hashed_password)) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        header("Location: view_projects.php");
                        exit();
                    } else {
                        header("Location: login.php?incorrect_password=true");
                        exit();
                    }
                }
            } else {
                echo "<p style='color: red;'>User not found. Please try again or register.</p>";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .body{
        background-image: url(img/pokemon.png);
        background-repeat: no-repeat;
        background-size: cover;
        z-index: 9999;
    }
    </style>
</head>
<body class="body">
    
    <div id="login">
        <form class="loginform" action="" method="post">
            <?php
            if (isset($_GET['incorrect_password']) && $_GET['incorrect_password'] == 'true') {
                echo "<p style='color: red;'>Incorrect password. Please try again.</p>";
            }
            ?>

            <label for="username">Username</label>
            <input type="text" id="username" name="name" required><br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
            <button  onclick="window.location.href='register.php'" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
