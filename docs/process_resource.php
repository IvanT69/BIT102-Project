<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taste_tribe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- CREATE: Handle New Submission ---
if (isset($_POST['submit_resource'])) {
    $title = htmlspecialchars(strip_tags($_POST['title']));
    $category = $_POST['category'];
    $content = htmlspecialchars(strip_tags($_POST['content']));

    if (empty($title) || empty($content)) {
        header("Location: Resources.php?error=emptyfields");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO resources (title, category, content) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $category, $content);

    if ($stmt->execute()) {
        header("Location: Resources.php?success=created");
    } else {
        header("Location: Resources.php?error=sqlerror");
    }
    $stmt->close();
}

// --- DELETE: Handle Resource Removal ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); 

    $stmt = $conn->prepare("DELETE FROM resources WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: Resources.php?success=deleted");
    } else {
        header("Location: Resources.php?error=deletefailed");
    }
    $stmt->close();
}

$conn->close();
?>