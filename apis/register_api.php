<?php 
require("../model/conn.php");
header("content-type:application/json");

if(isset($_POST['action'])){
    $action = $_POST['action'];
    if(function_exists($action)){
        $action($conn);
    } else {
        echo json_encode(["status"=>"error","message"=>"Invalid Action"]);
    }
} else {
    echo json_encode(["status"=>"error","message"=>"Action Is Required!"]);
}

// REGISTER FUNCTION
function registerF($conn) {
    if (isset($_POST['registerF']) && $_POST['registerF'] == "Exercise123") {
        
        // Sanitize input
        $studentName = mysqli_real_escape_string($conn, trim($_POST['studentName']));
        $studentEmail = mysqli_real_escape_string($conn, trim($_POST['studentEmail']));
        $studentBatch = mysqli_real_escape_string($conn, trim($_POST['studentBatch']));
        $studentGroup = mysqli_real_escape_string($conn, trim($_POST['studentGroup']));

        // Validation
        if (empty($studentName) || empty($studentEmail) || empty($studentBatch) || empty($studentGroup)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
           
        }
        else{
   // Check if email already registered
        $read_old = mysqli_query($conn, "SELECT * FROM students WHERE studentEmail='$studentEmail'");
        if ($read_old && mysqli_num_rows($read_old) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'This student email is already registered']);   
        }
        else{
        // Insert new student
        $register_query = mysqli_query($conn, "INSERT INTO students (studentName, studentEmail, studentBatch, studentGroup) VALUES ('$studentName', '$studentEmail', '$studentBatch', '$studentGroup')");
        if ($register_query)
         {
            $new_id = mysqli_insert_id($conn);
            echo json_encode(["status" => "success", "message" => "Successfully Student Registered", "id" =>$new_id]);
        }
         else {
            echo json_encode(['status' => 'error', 'message' => 'Student Registration Failed!']);
          }
        } 
     }
}else
 {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Register And Password Is Required']);
    }
}
?>
