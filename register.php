<?php 
require("model/conn.php");

$select_batches = mysqli_query($conn,"SELECT * FROM batches");
$select_groups = mysqli_query($conn,"SELECT * FROM groups");
?>



<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
	<meta property="og:title" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
	<meta property="og:description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
	<meta property="og:image" content="https://fillow.dexignlab.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>Admin Dashboard</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="views/image/png" href="images/favicon.png">
    <link href="views/css/style.css" rel="stylesheet">

</head>

<body">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Registration Form</h3>
            </div>
            <div class="card-body">
                 <form id="addFormStudent">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" >
                    </div>
                    <div class="mb-3">
                        <label for="studentEmail" class="form-label">Student Email</label>
                        <input type="email" class="form-control" id="studentEmail" name="studentEmail" >
                    </div>
                    <div class="mb-3">
                        <label for="studentBatch" class="form-label">Student Batch</label>
                       <select class="form-select" id="studentBatch" name="studentBatch" >
                        <option value="">Select Batches</option>
                            <?php  
                            if(mysqli_num_rows($select_batches) > 0){
                                while($row = mysqli_fetch_assoc($select_batches)){
                                    echo '<option value="'.$row['id'].'">'.$row['batchName'].'</option>';
                                }
                            } else {
                                echo '<option disabled selected>No batch found</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="studentGroup" class="form-label">Student Group</label>
                        <select class="form-select" id="studentGroup" name="studentGroup" >
                              <option value="">Select Groups</option>
                        <?php  
                        if(mysqli_num_rows($select_groups) > 0){
                            while($row = mysqli_fetch_assoc($select_groups)){
                                echo '<option value="'.$row['id'].'">'.$row['groupName'].'</option>';
                            }
                        } else {
                            echo '<option disabled selected>No group found</option>';
                        }
                        ?>
                    </select>

                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
        </div>
     </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="views/js/custom.min.js"></script>
    <script src="views/js/dlabnav-init.js"></script>
	<script src="views/js/styleSwitcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="views/js/add.js"></script>
</body>
</html>