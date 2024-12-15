<?php
require 'conn.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Delete user data
    $sql = "DELETE FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error deleting record.";
    }
} else {
    header("Location: display.php");
    exit();
}

$conn->close();
?>
