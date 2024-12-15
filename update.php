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

    // Fetch user data
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $role = $_POST['role'];

        // Update user data
        $updateSql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sss", $name, $role, $matric);

        if ($updateStmt->execute()) {
            header("Location: display.php");
            exit();
        } else {
            echo "Error updating record.";
        }
    }
} else {
    header("Location: display.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff; /* White background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .update-container {
            background: #f4f4f5; /* Zinc color */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        select {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
        }
        button {
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #555;
        }
        .cancel-link {
            text-align: center;
            margin-top: 10px;
        }
        .cancel-link a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .cancel-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="update-container">
        <h2>Update User</h2>
        <form action="update.php?matric=<?php echo $matric; ?>" method="post">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" value="<?php echo $user['matric']; ?>" disabled>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">Please select</option>
                <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
            </select>
            
            <button type="submit">Update</button>
        </form>
        <div class="cancel-link">
            <a href="display.php">Cancel</a>
        </div>
    </div>
</body>
</html>
