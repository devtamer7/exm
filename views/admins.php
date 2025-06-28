<?php
require("../includes/header.php");
require("../includes/sidebar.php");
?>


        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admins</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Admins</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Admins</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                            + Add Admin
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
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

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdminForm">
                    <div class="mb-3">
                        <label for="adminName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="adminName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="adminEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="adminEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="adminPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="adminPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="adminIsActive" class="form-label">Is Active</label>
                        <select class="form-select" id="adminIsActive" name="isActive">
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

<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAdminForm">
                    <input type="hidden" id="editAdminId" name="id">
                    <div class="mb-3">
                        <label for="editAdminName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editAdminName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAdminEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editAdminEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAdminPassword" class="form-label">Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="editAdminPassword" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="editAdminIsActive" class="form-label">Is Active</label>
                        <select class="form-select" id="editAdminIsActive" name="isActive">
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
<script src="js/admins.js"></script>