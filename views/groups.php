<?php
require("../includes/header.php");
require("../includes/sidebar.php");
?>


        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Groups</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Groups</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Groups</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                            + Add Group
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Group Name</th>
                                        <th>Group Mentor</th>
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

<!-- Add Group Modal -->
<div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGroupModalLabel">Add Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addGroupForm">
                    <div class="mb-3">
                        <label for="groupName" class="form-label">Group Name</label>
                        <input type="text" class="form-control" id="groupName" name="groupName" required>
                    </div>
<div class="mb-3">
    <label for="groupMentor" class="form-label">Group Mentor</label>
    <select class="form-select" id="groupMentor" name="groupMentor" required>
        <option value="">Select Mentor</option>
    </select>
</div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Group Modal -->
<div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGroupModalLabel">Edit Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editGroupForm">
                    <input type="hidden" id="editGroupId" name="id">
                    <div class="mb-3">
                        <label for="editGroupName" class="form-label">Group Name</label>
                        <input type="text" class="form-control" id="editGroupName" name="groupName" required>
                    </div>
<div class="mb-3">
    <label for="editGroupMentor" class="form-label">Group Mentor</label>
    <select class="form-select" id="editGroupMentor" name="groupMentor" required>
        <option value="">Select Mentor</option>
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
<script src="js/groups.js"></script>
