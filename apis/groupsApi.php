<?php
// Header Application
header("content-type:application/json");

// Calling Connection File
require("../model/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getStudentsCountPerGroup') {
    $sql = "SELECT g.groupName, COUNT(s.id) AS studentCount
            FROM groups g
            LEFT JOIN students s ON g.id = s.studentGroup
            GROUP BY g.groupName";
    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['groupName']] = $row['studentCount'];
    }

    echo json_encode($data);
    exit();
}



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
function getGroups($conn)
{
    $data = [];

    $select = mysqli_query($conn , "SELECT g.id, g.groupName, m.mentorName, g.create_date, g.groupMentor FROM groups g LEFT JOIN mentors m ON g.groupMentor = m.id");
    if($select && mysqli_num_rows($select) > 0)
    {
        while($row = mysqli_fetch_assoc($select))
        {
           $data[] = [
                'id' => $row['id'],
                'groupName' => $row['groupName'],
                'mentorName' => $row['mentorName'],
                'groupMentor' => $row['groupMentor'],
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

// insertGroup
function addGroup($conn)
{
    // Server-side validation
    if (empty($_POST['groupName']) || empty($_POST['groupMentor'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        return;
    }

    $groupName = $_POST['groupName'];
    $groupMentor = $_POST['groupMentor'];

    $insert = mysqli_query($conn, "INSERT INTO `groups`(`groupName`, `groupMentor`) VALUES ('$groupName','$groupMentor')");

    if($insert)
    {
        echo json_encode(['status' => 'success', 'message' => 'Group Inserted Successfully']);
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'Group Inserted Failed']);
    }
}

// Update Group
function updateGroup($conn) {
    // Server-side validation
    if (empty($_POST['id']) || empty($_POST['groupName']) || empty($_POST['groupMentor'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        return;
    }

    $id = $_POST['id'];
    $groupName = $_POST['groupName'];
    $groupMentor = $_POST['groupMentor'];

    $update = mysqli_query($conn, "UPDATE `groups` SET `groupName`='$groupName', `groupMentor`='$groupMentor' WHERE `id`='$id'");

    if ($update) {
        echo json_encode(['status' => 'success', 'message' => 'Group Updated Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Group Updated Failed']);
    }
}

// Delete Group
function deleteGroup($conn) {
    if (empty($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Group ID is required']);
        return;
    }

    $id = $_POST['id'];

    $delete = mysqli_query($conn, "DELETE FROM `groups` WHERE `id`='$id'");

    if ($delete) {
        echo json_encode(['status' => 'success', 'message' => 'Group Deleted Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Group Deleted Failed']);
    }
}

// Get Mentors
function getMentors($conn) {
    $data = [];

    $select = mysqli_query($conn , "SELECT id, mentorName FROM mentors");
    if($select && mysqli_num_rows($select) > 0)
    {
        while($row = mysqli_fetch_assoc($select))
        {
            $data[] = [
                'id' => $row['id'],
                'mentorName' => $row['mentorName']
            ];
        }

        echo json_encode($data);
    }
    else
    {
        echo json_encode(['status' => 'success', 'message' => 'No mentors found']);
    }
}
?>
