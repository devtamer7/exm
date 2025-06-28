<?php
// Header Application
header("content-type:application/json");

// Calling Connection File
require("../model/conn.php");

// Action
if(isset($_POST['action']))
{
    $action = $_POST['action'];
    // cheack if Action is Exit
    if(function_exists($action))
    {
        $action($conn);
    }
    else
    {
        echo json_encode(['status'=>'error','message'=>'Action Is Not Exit']);
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') // Only return "Action Is Required" for POST requests without an action
{
    echo json_encode(['status'=>'error','message'=>'Action Is Required']);
}

// Read Action
function getAdmins($conn)
{
    $data = [];

    // Exclude the first admin (id = 1)
    $select = mysqli_query($conn , "SELECT `id`, `name`, `email`, `isActive`, `create_date` FROM `admins` WHERE `id` != 1");
    if($select && mysqli_num_rows($select) > 0)
    {
        while($row = mysqli_fetch_assoc($select))
        {
           $data[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'isActive' => $row['isActive'],
                'create_date' => $row['create_date']
            ];
        }

        echo json_encode($data);
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'No Data Found']);
    }
}

// Add Admin
function addAdmin($conn)
{
    // Server-side validation
    if (!isset($_POST['name']) || trim($_POST['name']) === '' ||
        !isset($_POST['email']) || trim($_POST['email']) === '' ||
        !isset($_POST['password']) || empty($_POST['password']) || // Password must be provided for add
        !isset($_POST['isActive']) || !in_array($_POST['isActive'], ['0', '1'], true)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        return;
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $isActive = $_POST['isActive'];

    $insert = mysqli_query($conn, "INSERT INTO `admins`(`name`, `email`, `password`, `isActive`) VALUES ('$name','$email','$password','$isActive')");

    if($insert)
    {
        echo json_encode(['status' => 'success', 'message' => 'Admin Inserted Successfully']);
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'Admin Inserted Failed']);
    }
}

// Update Admin
function updateAdmin($conn) {
    // Server-side validation
    if (!isset($_POST['id']) || trim($_POST['id']) === '' ||
        !isset($_POST['name']) || trim($_POST['name']) === '' ||
        !isset($_POST['email']) || trim($_POST['email']) === '' ||
        !isset($_POST['isActive']) || !in_array($_POST['isActive'], ['0', '1'], true)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        return;
    }

    error_log("Admin Update - Raw POST data: " . print_r($_POST, true), 3, "admin_error.log");

    $id = (int)$_POST['id']; // Explicitly cast to integer
    error_log("Admin Update - Processed ID: " . $id, 3, "admin_error.log");

    // Prevent updating the first admin (id = 1)
    if ($id == 1) {
        echo json_encode(['status' => 'error', 'message' => 'Cannot update the first admin']);
        return;
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $isActive = $_POST['isActive'];

    $updateFields = [];
    $bindTypes = "";
    $bindParams = [];

    $updateFields[] = "`name` = ?";
    $bindTypes .= "s";
    $bindParams[] = &$name;
    error_log("Admin Update - Name: " . $name, 3, "admin_error.log");

    $updateFields[] = "`email` = ?";
    $bindTypes .= "s";
    $bindParams[] = &$email;
    error_log("Admin Update - Email: " . $email, 3, "admin_error.log");

    $updateFields[] = "`isActive` = ?";
    $bindTypes .= "i"; // Assuming isActive is an integer (0 or 1)
    $bindParams[] = &$isActive;
    error_log("Admin Update - IsActive: " . $isActive, 3, "admin_error.log");

    // Only update password if provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $updateFields[] = "`password` = ?";
        $bindTypes .= "s";
        $bindParams[] = &$password;
        error_log("Admin Update - Password (hashed): " . $password, 3, "admin_error.log");
    }

    $updateQuery = "UPDATE `admins` SET " . implode(', ', $updateFields) . " WHERE `id` = ?";
    $bindTypes .= "i"; // Assuming id is an integer
    $bindParams[] = &$id;

    error_log("Admin Update - Final Query String: " . $updateQuery, 3, "admin_error.log");
    error_log("Admin Update - Bind Types: " . $bindTypes, 3, "admin_error.log");
    error_log("Admin Update - Bind Params (values): " . implode(', ', array_map(function($p){return is_object($p) ? 'object' : $p;}, $bindParams)), 3, "admin_error.log");


    $stmt = mysqli_prepare($conn, $updateQuery);

    if ($stmt) {
        // Dynamically bind parameters
        call_user_func_array('mysqli_stmt_bind_param', array_merge([$stmt, $bindTypes], $bindParams));

        $execute = mysqli_stmt_execute($stmt);

        if ($execute) {
            echo json_encode(['status' => 'success', 'message' => 'Admin Updated Successfully']);
        } else {
            error_log("Admin Update - MySQL Statement Execution Error: " . mysqli_stmt_error($stmt), 3, "admin_error.log");
            echo json_encode(['status' => 'error', 'message' => 'Admin Updated Failed']);
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Admin Update - Prepare Statement Error: " . mysqli_error($conn), 3, "admin_error.log");
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare update statement']);
    }
}

// Delete Admin
function deleteAdmin($conn) {
    if (empty($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Admin ID is required']);
        return;
    }

    $id = $_POST['id'];

    // Prevent deleting the first admin (id = 1)
    if ($id == 1) {
        echo json_encode(['status' => 'error', 'message' => 'Cannot delete the first admin']);
        return;
    }

    $delete = mysqli_query($conn, "DELETE FROM `admins` WHERE `id`='$id'");

    if ($delete) {
        echo json_encode(['status' => 'success', 'message' => 'Admin Deleted Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Admin Deleted Failed']);
    }
}
?>
