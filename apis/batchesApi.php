<?php
// Header Application
header("content-type:application/json");

// Calling Connection File
require("../model/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getBatchStatusCounts') {
    $sql = "SELECT batchStatus, COUNT(*) AS count FROM batches GROUP BY batchStatus";
    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['batchStatus']] = $row['count'];
    }

    echo json_encode($data);
    exit(); // Add exit to prevent further execution
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getStudentsCountPerBatch') {
    $sql = "SELECT b.batchName, COUNT(s.id) AS studentCount
            FROM batches b
            LEFT JOIN students s ON b.id = s.studentBatch
            GROUP BY b.batchName";
    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['batchName']] = $row['studentCount'];
    }

    echo json_encode($data);
    exit();
}

// Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if (function_exists($action)) {
        $action($conn);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Action Is Not Exit']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Only return "Action Is Required" for POST requests without an action
    echo json_encode(['status' => 'error', 'message' => 'Action Is Required']);
}

// Read Action
function getBatches($conn)
{
    $data = [];

    $select = mysqli_query($conn , "SELECT * FROM `batches` ");
    if($select && mysqli_num_rows($select) > 0)
    {
        while($row = mysqli_fetch_assoc($select))
        {
            $data[] = [
                'id' => $row['id'], // Changed to 'id' to match expected key in students.js
                'batchName' => $row['batchName'],
                'batchStartDate' => $row['batchStartDate'],
                'batchStatus' => $row['batchStatus']
            ];
        }

        echo json_encode($data);
        exit(); // Add exit to prevent further execution
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'No Data Found']);
        exit(); // Add exit to prevent further execution
    }
}

// insertBatches
function insertBatches($conn)
{
    // Server-side validation
    if (empty($_POST['batchName']) || empty($_POST['batchStartDate']) || empty($_POST['batchStatus'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        return;
    }

    $batchName = $_POST['batchName'];
    $batchStartDate = $_POST['batchStartDate'];
    $batchStatus = $_POST['batchStatus'];

    $sql = "INSERT INTO `batches`(`batchName`, `batchStartDate`, `batchStatus`) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $batchName, $batchStartDate, $batchStatus);
    $insert = mysqli_stmt_execute($stmt);

    if($insert)
    {
        echo json_encode(['status' => 'success', 'message' => 'Batch Inserted Successfully']);
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'Batch Inserted Failed']);
    }
}

// Update Batches
function updateBatches($conn) {
    // Server-side validation
    if (empty($_POST['batchId']) || empty($_POST['batchName']) || empty($_POST['batchStartDate']) || empty($_POST['batchStatus'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        return;
    }

    $batchId = $_POST['batchId'];
    $batchName = $_POST['batchName'];
    $batchStartDate = $_POST['batchStartDate'];
    $batchStatus = $_POST['batchStatus'];

    $sql = "UPDATE `batches` SET `batchName`=?, `batchStartDate`=?, `batchStatus`=? WHERE `id`=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $batchName, $batchStartDate, $batchStatus, $batchId);
    $update = mysqli_stmt_execute($stmt);

    if ($update) {
        echo json_encode(['status' => 'success', 'message' => 'Batch Updated Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Batch Updated Failed']);
    }
}

// Delete Batches
function deleteBatches($conn) {
    if (empty($_POST['batchId'])) {
        echo json_encode(['status' => 'error', 'message' => 'Batch ID is required']);
        return;
    }

    $batchId = $_POST['batchId'];

    $sql = "DELETE FROM `batches` WHERE `id`=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $batchId);
    $delete = mysqli_stmt_execute($stmt);

    if ($delete) {
        echo json_encode(['status' => 'success', 'message' => 'Batch Deleted Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Batch Deleted Failed']);
    }
}

?>
