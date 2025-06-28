$(document).ready(function() {

    // Read Data Request
    function readAdmins() {
        $.ajax({
            type: "POST",
            url: "../apis/adminsApi.php",
            data: { "action": "getAdmins" },
            dataType: "json",
            success: function (response) {
                if (Array.isArray(response)) {
                    // Destroy existing DataTable if it exists
                    if ($.fn.DataTable.isDataTable("#example3")) {
                        $('#example3').DataTable().destroy();
                    }

                    // Clear existing rows
                    $('#example3 tbody').html("");

                    // Add new rows
                    response.forEach(function (row, index) {
                        let actionButtons = '';
                        if (row.id != 1) { // Allow edit/delete for admins other than the first one
                            actionButtons = `
                                <button class="btn btn-primary shadow btn-xs sharp me-1 edit-admin" 
                                    data-adminid="${row.id}" 
                                    data-adminname="${row.name}" 
                                    data-adminemail="${row.email}" 
                                    data-adminisactive="${row.isActive}">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-danger shadow btn-xs sharp delete-admin" data-adminid="${row.id}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            `;
                        } else {
                            actionButtons = `
                                <button class="btn btn-primary shadow btn-xs sharp me-1" disabled>
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-danger shadow btn-xs sharp" disabled>
                                    <i class="fa fa-trash"></i>
                                </button>
                            `;
                        }

                        $('#example3 tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.name}</td>
                                <td>${row.email}</td>
                                <td>${row.isActive == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'}</td>
                                <td>${row.create_date}</td>
                                <td>
                                    <div class="d-flex">
                                        ${actionButtons}
                                    </div>
                                </td>
                            </tr>
                        `);
                    });

                    // Re-initialize DataTable
                    $('#example3').DataTable({
                        pageLength: 10,
                        lengthChange: true,
                        searching: true,
                        ordering: true
                    });
                } else {
                    console.error("Response is not a valid array");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

    // Load admins
    readAdmins();

    // Add Admin
    $(document).on("submit", "#addAdminForm", function(e) {
        e.preventDefault();

        // Form validation
        let adminName = $("#adminName").val();
        let adminEmail = $("#adminEmail").val();
        let adminPassword = $("#adminPassword").val();
        let adminIsActive = $("#adminIsActive").val();

        if (adminName == "" || adminEmail == "" || adminPassword == "" || adminIsActive == "") {
            Swal.fire({
                title: "Error",
                text: "Please fill in all fields",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        // Storing form Data
        let formData = new FormData(this);

        // Action
        formData.append("action", "addAdmin");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/adminsApi.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.status == "error") {
                    Swal.fire({
                        title: response.status,
                        text: response.message,
                        icon: response.status.toLowerCase(),
                        confirmButtonText: "OK"
                    });
                } else if (response.status == "success") {
                    Swal.fire({
                        title: response.status,
                        text: response.message,
                        icon: response.status.toLowerCase(),
                        confirmButtonText: "OK"
                    }).then(() => {
                        // Load admins
                        readAdmins();
                        // Reset The Form
                        $("#addAdminForm")[0].reset();
                        $('#addAdminModal').modal('hide');

                    });
                }

            }
        });

    });

    // Edit Admin
    $(document).on("click", ".edit-admin", function() {
        let adminId = $(this).data("adminid");
        let adminName = $(this).data("adminname");
        let adminEmail = $(this).data("adminemail");
        let adminIsActive = $(this).data("adminisactive");

        $("#editAdminId").val(adminId);
        $("#editAdminName").val(adminName);
        $("#editAdminEmail").val(adminEmail);
        $("#editAdminIsActive").val(adminIsActive).trigger('change');
    
        console.log("Edit Admin - ID:", adminId, "Name:", adminName, "Email:", adminEmail, "Is Active:", adminIsActive);
        // Open the update modal
        $("#editAdminModal").modal("show");
    });

    $(document).on("submit", "#editAdminForm", function(e) {
        e.preventDefault();

        // Form validation
        let adminName = $("#editAdminName").val();
        let adminEmail = $("#editAdminEmail").val();
        let adminIsActive = $("#editAdminIsActive").val();
        let adminId = $("#editAdminId").val();

        if (adminName == "" || adminEmail == "" || adminIsActive == "") {
            Swal.fire({
                title: "Error",
                text: "Please fill in all fields",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        // Storing form Data
        let formData = new FormData(this);
        formData.append("id", adminId); // Explicitly append the adminId

        // Action
        formData.append("action", "updateAdmin");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/adminsApi.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // Close the modal
                $("#editAdminModal").modal("hide");

                Swal.fire({
                    title: response.status,
                    text: response.message,
                    icon: response.status.toLowerCase(),
                    confirmButtonText: "OK"
                }).then(() => {
                    // Load admins
                    readAdmins();
                });
            }
        });

    });

    // Delete Admin
    $(document).on("click", ".delete-admin", function() {
        let adminId = $(this).data("adminid");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../apis/adminsApi.php",
                    data: { action: "deleteAdmin", id: adminId },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: response.status,
                            text: response.message,
                            icon: response.status.toLowerCase(),
                            confirmButtonText: "OK"
                        }).then(() => {
                            // Load admins
                            readAdmins();
                        });
                    }
                });
            }
        });
    });

});
