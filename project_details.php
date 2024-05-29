<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $project_id = intval($_GET['id']);

            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'portofolio');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM projects WHERE id = $project_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $layout = $row["layout"];
                
                echo "<h1>" . $row["name"] . "</h1>";
                
                switch ($layout) {
                    case 'layout1':
                        echo "<div class='layout1'>";
                        echo "<img src='" . $row["image_path"] . "' alt='Project Image'>";
                        echo "<p>" . $row["description"] . "</p>";
                        echo "</div>";
                        break;
                    case 'layout2':
                        echo "<div class='layout2'>";
                        echo "<p>" . $row["description"] . "</p>";
                        echo "<img src='" . $row["image_path"] . "' alt='Project Image'>";
                        echo "</div>";
                        break;
                    case 'layout3':
                        echo "<div class='layout3'>";
                        echo "<img src='" . $row["image_path"] . "' alt='Project Image' style='float:left; margin-right: 20px;'>";
                        echo "<p>" . $row["description"] . "</p>";
                        echo "<div style='clear:both;'></div>";
                        echo "</div>";
                        break;
                    default:
                        echo "<p>Invalid layout selected</p>";
                }

                echo "<a href='view_projects.php' class='btn'>Back to Projects</a>";
            } else {
                echo "<p>Project not found</p>";
            }

            $conn->close();
        } else {
            echo "<p>No project ID provided</p>";
        }
        ?>
    </div>
</body>
</html>
