<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Projects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="index.php" class="btn btn-primary">Home</a>
    <div class="container">
        <h1>All Projects</h1>
        <a href="add_project.php" class="btn">Add New Project</a>
        <div class="project-list">
            <?php
            // Database connection
            $conn = new mysqli('localhost', 'portofolio', '2024', 'portofolio');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, name, image_path FROM projects";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='project-item'>";
                    echo "<img src='" . $row["image_path"] . "' alt='Project Image'>";
                    echo "<h2>" . $row["name"] . "</h2>";
                    echo "<a href='project_details.php?id=" . $row["id"] . "' class='btn'>View Details</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No projects found</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
