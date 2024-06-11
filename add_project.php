<a href="index.php" class="btn btn-primary">Home</a>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $layout = $_POST['layout']; // Capture the selected layout

    // Ensure the uploads directory exists
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Handle the file upload
    $uploadOk = 1;
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
    
        if ($_FILES["image"]["size"] > 100000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                $target_file = ""; // Reset target file if upload failed
            }
        }
    } else {
        echo "No file was uploaded or there was an error with the file upload.";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 1) {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'portofolio');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO projects (name, description, image_path, layout) VALUES ('$name', '$description', '$target_file', '$layout')";

        if ($conn->query($sql) === TRUE) {
            echo "New project added successfully. <a href='view_projects.php'>View Projects</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Project</h1>
        <a href="logout.php" class="btn">Logout</a>
        <form action="add_project.php" method="post" enctype="multipart/form-data">
            <label for="name">Project Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            <label for="description">Project Description:</label><br>
            <textarea id="description" name="description" required></textarea><br><br>
            <label for="image">Project Image:</label><br>
            <input type="file" id="image" name="image" required><br><br>
            <label for="layout">Select Layout:</label><br>
            <select id="layout" name="layout" required>
                <option value="layout1">Layout 1</option>
                <option value="layout2">Layout 2</option>
                <option value="layout3">Layout 3</option>
            </select><br><br>
            <input type="submit" value="Add Project">
        </form>
    </div>
</body>
</html>
