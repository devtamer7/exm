<?php
require("../includes/header.php");
require("../includes/sidebar.php");
?>


        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Mentors</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Mentors</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Mentors</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMentorModal">
                            + Add Mentor
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mentor Name</th>
                                        <th>Mentor Email</th>
                                        <th>Mentor Group</th>
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

<!-- Add Mentor Modal -->
<div class="modal fade" id="addMentorModal" tabindex="-1" aria-labelledby="addMentorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMentorModalLabel">Add Mentor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMentorForm">
                    <div class="mb-3">
                        <label for="mentorName" class="form-label">Mentor Name</label>
                        <input type="text" class="form-control" id="mentorName" name="mentorName" required>
                    </div>
                    <div class="mb-3">
                        <label for="mentorEmail" class="form-label">Mentor Email</label>
                        <input type="email" class="form-control" id="mentorEmail" name="mentorEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="mentorPassword" class="form-label">Mentor Password</label>
                        <input type="password" class="form-control" id="mentorPassword" name="mentorPassword" required>
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

<!-- Edit Mentor Modal -->
<div class="modal fade" id="editMentorModal" tabindex="-1" aria-labelledby="editMentorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMentorModalLabel">Edit Mentor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMentorForm">
                    <input type="hidden" id="editMentorId" name="id">
                    <div class="mb-3">
                        <label for="editMentorName" class="form-label">Mentor Name</label>
                        <input type="text" class="form-control" id="editMentorName" name="mentorName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMentorEmail" class="form-label">Mentor Email</label>
                        <input type="email" class="form-control" id="editMentorEmail" name="mentorEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="editMentorPassword" class="form-label">Mentor Password</label>
                        <input type="password" class="form-control" id="editMentorPassword" name="mentorPassword">
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
<script src="js/mentors.js"></script>
