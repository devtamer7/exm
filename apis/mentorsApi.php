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
else
{
    echo json_encode(['status'=>'error','message'=>'Action Is Required']);
}

// Read Action
function getMentors($conn)
{
    $data = [];

    $select = mysqli_query($conn , "SELECT * FROM mentors");
    if($select && mysqli_num_rows($select) > 0)
    {
        while($row = mysqli_fetch_assoc($select))
        {
            $selectMentorGroup = mysqli_query($conn,"SELECT * FROM groups WHERE groupMentor='$row[id]'");
            if($selectMentorGroup && mysqli_num_rows($selectMentorGroup)>0)
            {
                $groupRow = mysqli_fetch_assoc($selectMentorGroup);
                $mentorGroup = $groupRow['groupName'];
               
            }
            else
            {
                $mentorGroup="No Group!";
            }
            $data[] = [
                'id' => $row['id'],
                'mentorName' => $row['mentorName'],
                'mentorEmail' => $row['mentorEmail'],
                'mentorGroup' =>  $mentorGroup,
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

// insertMentor
function addMentor($conn)
{
    

    $mentorName = $_POST['mentorName'];
    $mentorEmail = $_POST['mentorEmail'];
    // Set default values for mentorPassword and isActive
    

    $insert = mysqli_query($conn, "INSERT INTO `mentors`(`mentorName`, `mentorEmail`) VALUES ('$mentorName','$mentorEmail')");

    if($insert)
    {
        echo json_encode(['status' => 'success', 'message' => 'Mentor Inserted Successfully']);
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'Mentor Inserted Failed']);
    }
}

// Update Mentor
function updateMentor($conn) {
    // Server-side validation
    if (empty($_POST['id']) || empty($_POST['mentorName']) || empty($_POST['mentorEmail']) || !isset($_POST['isActive'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields except password']);
        return;
    }

    $id = $_POST['id'];
    $mentorName = $_POST['mentorName'];
    $mentorEmail = $_POST['mentorEmail'];
    $mentorPassword = $_POST['mentorPassword'];
    $isActive = $_POST['isActive'];

    $update = mysqli_query($conn, "UPDATE `mentors` SET `mentorName`='$mentorName', `mentorEmail`='$mentorEmail',  `mentorPassword`='$mentorPassword', `isActive`='$isActive' WHERE `id`='$id'");

    if ($update) {
        echo json_encode(['status' => 'success', 'message' => 'Mentor Updated Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Mentor Updated Failed']);
    }
}

// Delete Mentor
function deleteMentor($conn) {
    if (empty($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Mentor ID is required']);
        return;
    }

    $id = $_POST['id'];

    $delete = mysqli_query($conn, "DELETE FROM `mentors` WHERE `id`='$id'");

    if ($delete) {
        echo json_encode(['status' => 'success', 'message' => 'Mentor Deleted Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Mentor Deleted Failed']);
    }
}
