<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Registratie</title>
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

    
    <h1>Registratie</h1>
    <?php
    // Database configuration
    $host = 'localhost';
    $dbname = 'portofolio';
    $username = 'portofolio';
    $password = '2024'; // You may need to set a password here if your MySQL server requires it.

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Gegevens uit het registratieformulier halen en veilig maken
            $username = htmlspecialchars($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            // SQL-query om de gegevens in de database in te voegen
            $query = "INSERT INTO users (Username, Password, email) VALUES (:username, :password, :email)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            
            $stmt->execute();
            header("Location: login.php");
            exit();
        } catch(PDOException $e) {
            echo "Fout bij registratie: " . $e->getMessage();
        }
    }
    ?>

    <form action="" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required><br><br>

        <input type="submit" value="Registreren">
    </form>
</body>
</html>
