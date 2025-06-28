<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Adjusted width for more fields */
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .login-container input[type="text"],
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        /* Select2 specific styling adjustments */
        .select2-container {
            width: 100% !important; /* Ensure Select2 container takes full width */
            box-sizing: border-box;
        }
        .select2-container .select2-selection--single {
            height: 38px; /* Match input height */
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff; /* Ensure background is white */
            display: flex; /* Use flexbox for alignment */
            align-items: center; /* Vertically center content */
            padding-left: 10px; /* Add padding to the left */
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444; /* Default text color */
            padding: 0; /* Remove default padding */
            line-height: normal; /* Reset line-height */
            flex-grow: 1; /* Allow text to grow and fill space */
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px; /* Vertically align arrow */
            position: relative; /* Adjust position */
            top: auto; /* Reset top */
            right: 5px; /* Adjust right position */
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #999;
        }
        .login-container button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        /* Custom Alert Styles */
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: left;
            display: none; /* Hidden by default */
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="login-container">
        <h2>Student Registration</h2>
        <div id="alertMessage" class="alert"></div>
        <form id="studentRegistrationForm" action="../controller/process_registration.php" method="POST">
            <div class="form-group">
                <label for="studentName" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="studentName" name="studentName" required>
            </div>
            <div class="form-group">
                <label for="studentEmail" class="form-label">Student Email</label>
                <input type="email" class="form-control" id="studentEmail" name="studentEmail" required>
            </div>
            <div class="form-group">
                <label for="studentBatch" class="form-label">Student Batch</label>
                <select id="studentBatch" name="studentBatch" required style="width: 100%;">
                    <option value="">Select Batch</option>
                </select>
            </div>
            <div class="form-group">
                <label for="studentGroup" class="form-label">Student Group</label>
                <select id="studentGroup" name="studentGroup" required style="width: 100%;">
                    <option value="">Select Group</option>
                </select>
            </div>
            <div class="form-group">
                <label for="studentPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="studentPassword" name="studentPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p style="margin-top: 20px;">Already have an account? <a href="../login.php">Login here</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="js/register.js"></script>
</body>
</html>