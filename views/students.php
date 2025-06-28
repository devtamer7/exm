<?php
require("../includes/header.php");
require("../includes/sidebar.php");
?>

        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Students</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Students</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Students</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            + Add Student
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Student Email</th>
                                        <th>Student Batch</th>
                                        <th>Student Group</th>
                                        <th>Is Active</th>
                                        <th>Create Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentEmail" class="form-label">Student Email</label>
                        <input type="email" class="form-control" id="studentEmail" name="studentEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentBatch" class="form-label">Student Batch</label>
                        <select class="form-select" id="studentBatch" name="studentBatch" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="studentGroup" class="form-label">Student Group</label>
                        <select class="form-select" id="studentGroup" name="studentGroup" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="studentPassword" class="form-label">Student Password</label>
                        <input type="password" class="form-control" id="studentPassword" name="studentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="isActive" class="form-label">Is Active</label>
                        <select class="form-select" id="isActive" name="isActive" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
                    <input type="hidden" id="editStudentId" name="id">
                    <div class="mb-3">
                        <label for="editStudentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="editStudentName" name="studentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentEmail" class="form-label">Student Email</label>
                        <input type="email" class="form-control" id="editStudentEmail" name="studentEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentBatch" class="form-label">Student Batch</label>
                        <select class="form-select" id="editStudentBatch" name="studentBatch" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentGroup" class="form-label">Student Group</label>
                        <select class="form-select" id="editStudentGroup" name="studentGroup" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentPassword" class="form-label">Student Password</label>
                        <input type="password" class="form-control" id="editStudentPassword" name="studentPassword">
                    </div>
                    <div class="mb-3">
                        <label for="editIsActive" class="form-label">Is Active</label>
                        <select class="form-select" id="editIsActive" name="isActive" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require("../includes/footer.php");
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="js/students.js"></script>
