<?php
require 'conn.php'; // Include the database connection
session_start(); // Ensure session is started

// Check if the user is logged in
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

// Fetch all users
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff; /* White background */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
        }
        .container {
            background: #f4f4f5; /* Zinc color */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 800px;
            margin-top: 30px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            text-align: left;
            padding: 10px;
            font-size: 14px;
        }
        th {
            background-color: #e0e0e0;
        }
        td {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #555;
        }
        .logout {
            text-align: center;
            margin-bottom: 20px;
        }
        .logout a {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }
        .logout a:hover {
            background-color: #555;
        }
        .no-data {
            text-align: center;
            font-size: 16px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="logout">
            <a href="logout.php">Logout</a>
        </div>    
    <h2>Manage Users</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['matric'] . "</td>
                                <td>" . $row['name'] . "</td>
                                <td>" . $row['role'] . "</td>
                                <td>
                                    <a href='update.php?matric=" . $row['matric'] . "'>Update</a> |
                                    <a href='delete.php?matric=" . $row['matric'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='no-data'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
