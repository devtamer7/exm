<?php
// Header Application
header("content-type:application/json");

// Calling Connection File
require("../model/conn.php");

// Header Application
header("content-type:application/json");

// Calling Connection File
require("../model/conn.php");
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getStudentStatusCounts') {
    $sql = "SELECT 
                CASE 
                    WHEN b.batchStatus = 'Complete' THEN 'Complete' 
                    WHEN b.batchStatus = 'Ongoing' THEN 'Ongoing' 
                    ELSE 'Unknown' 
                END AS studentStatus,
                COUNT(s.id) AS count
            FROM students s
            LEFT JOIN batches b ON s.studentBatch = b.id
            GROUP BY studentStatus";

    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['studentStatus']] = $row['count'];
    }

    echo json_encode($data);
    exit(); // Add exit to prevent further execution
}

// Action
if (isset($_POST['action']))
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
else
{
    echo json_encode(['status'=>'error','message'=>'Action Is Required']);
}

// Read Action
function getStudents($conn)
{
    $data = [];

    $select = mysqli_query($conn , "SELECT s.*, b.id AS batchId, b.batchName, g.id AS groupId, g.groupName FROM students s LEFT JOIN batches b ON s.studentBatch = b.id LEFT JOIN groups g ON s.studentGroup = g.id");
    if($select && mysqli_num_rows($select) > 0)
    {
        while($row = mysqli_fetch_assoc($select))
        {
            $data[] = [
                'id' => $row['id'],
                'studentName' => $row['studentName'],
                'studentEmail' => $row['studentEmail'],
                'studentBatch' =>  $row['batchName'],
                'studentGroup' =>  $row['groupName'],
                'studentBatchId' => $row['batchId'],
                'studentGroupId' => $row['groupId'],
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

// insertStudent
function addStudent($conn)
{
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentBatch = $_POST['studentBatch'];
    $studentGroup = $_POST['studentGroup'];
    $studentPassword = $_POST['studentPassword'];
    $isActive = $_POST['isActive'];

    $sql = "INSERT INTO `students`(`studentName`, `studentEmail`, `studentBatch`, `studentGroup`, `studentPassword`, `isActive`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiisi", $studentName, $studentEmail, $studentBatch, $studentGroup, $studentPassword, $isActive);
    $insert = mysqli_stmt_execute($stmt);

    if($insert)
    {
        // Fetch batch and group names
        $selectBatch = mysqli_query($conn, "SELECT batchName FROM batches WHERE id = '$studentBatch'");
        $batchRow = mysqli_fetch_assoc($selectBatch);
        $batchName = $batchRow['batchName'];

        $selectGroup = mysqli_query($conn, "SELECT groupName FROM groups WHERE id = '$studentGroup'");
        $groupRow = mysqli_fetch_assoc($selectGroup);
        $groupName = $groupRow['groupName'];

        echo json_encode(['status' => 'success', 'message' => 'Student Inserted Successfully', 'batchName' => $batchName, 'groupName' => $groupName]);
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'Student Inserted Failed']);
    }
}

// Update Student
function updateStudent($conn) {
    // Server-side validation
    if (empty($_POST['id']) || empty($_POST['studentName']) || empty($_POST['studentEmail']) || empty($_POST['studentBatch']) || empty($_POST['studentGroup']) || !isset($_POST['isActive'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields except password']);
        return;
    }

    $id = $_POST['id'];
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentBatch = $_POST['studentBatch'];
    $studentGroup = $_POST['studentGroup'];
    $studentPassword = $_POST['studentPassword'];
    $isActive = $_POST['isActive'];

    $sql = "UPDATE `students` SET `studentName`=?, `studentEmail`=?, `studentBatch`=?, `studentGroup`=?, `studentPassword`=?, `isActive`=? WHERE `id`=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiissi", $studentName, $studentEmail, $studentBatch, $studentGroup, $studentPassword, $isActive, $id);
    $update = mysqli_stmt_execute($stmt);

    if ($update) {
        // Fetch batch and group names
        $selectBatch = mysqli_query($conn, "SELECT batchName FROM batches WHERE id = '$studentBatch'");
        $batchRow = mysqli_fetch_assoc($selectBatch);
        $batchName = $batchRow['batchName'];

        $selectGroup = mysqli_query($conn, "SELECT groupName FROM groups WHERE id = '$studentGroup'");
        $groupRow = mysqli_fetch_assoc($selectGroup);
        $groupName = $groupRow['groupName'];
        echo json_encode(['status' => 'success', 'message' => 'Student Updated Successfully',  'batchName' => $batchName, 'groupName' => $groupName]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Student Updated Failed']);
    }
}

// Delete Student
function deleteStudent($conn) {
    if (empty($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Student ID is required']);
        return;
    }

    $id = $_POST['id'];

    $sql = "DELETE FROM `students` WHERE `id`=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $delete = mysqli_stmt_execute($stmt);

    if ($delete) {
        echo json_encode(['status' => 'success', 'message' => 'Student Deleted Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Student Deleted Failed']);
    }
}

// Register Student
function registerStudent($conn)
{
    $response = ['status' => 'error', 'message' => ''];

    $studentName = trim($_POST['studentName'] ?? '');
    $studentEmail = trim($_POST['studentEmail'] ?? '');
    $studentBatch = trim($_POST['studentBatch'] ?? '');
    $studentGroup = trim($_POST['studentGroup'] ?? '');
    $studentPassword = $_POST['studentPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Server-side validation
    if (empty($studentName) || empty($studentEmail) || empty($studentBatch) || empty($studentGroup) || empty($studentPassword) || empty($confirmPassword)) {
        $response['message'] = "All fields are required.";
        echo json_encode($response);
        exit();
    }

    if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format.";
        echo json_encode($response);
        exit();
    }

    if (strlen($studentPassword) < 6) {
        $response['message'] = "Password must be at least 6 characters long.";
        echo json_encode($response);
        exit();
    }

    if ($studentPassword !== $confirmPassword) {
        $response['message'] = "Passwords do not match.";
        echo json_encode($response);
        exit();
    }

    try {
        // Check if email already exists
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM students WHERE studentEmail = ?");
        mysqli_stmt_bind_param($stmt, "s", $studentEmail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            $response['message'] = "Email already registered.";
            echo json_encode($response);
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($studentPassword, PASSWORD_DEFAULT);

        // Insert student into the database with isActive = 0
        $sql = "INSERT INTO `students`(`studentName`, `studentEmail`, `studentBatch`, `studentGroup`, `studentPassword`, `isActive`) VALUES (?, ?, ?, ?, ?, 0)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiis", $studentName, $studentEmail, $studentBatch, $studentGroup, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 'success';
            $response['message'] = 'Student registered successfully. Awaiting admin activation.';
        } else {
            $response['message'] = 'Failed to register student: ' . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        $response['message'] = "Server error: " . $e->getMessage();
    }

    echo json_encode($response);
}
