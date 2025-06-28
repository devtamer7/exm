<?php
session_start();

// Check if the user is logged in and is a mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mentor') {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }
        .dashboard-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        .dashboard-container h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .dashboard-container p {
            color: #555;
            margin-bottom: 20px;
        }
        .dashboard-container a {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
        }
        .dashboard-container a:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome to Mentor Dashboard</h2>
        <p>This is a placeholder for the mentor dashboard content.</p>
        <a href="../logout.php">Logout</a>
    </div>
</body>
</html>