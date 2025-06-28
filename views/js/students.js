$(document).ready(function() {

    // Read Data Request
    function readStudents() {
        $.ajax({
            type: "POST",
            url: "../apis/studentsApi.php",
            data: { "action": "getStudents" },
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
                        let statusBadge = "";
                        if (row.isActive == 1) {
                            statusBadge = `<span class="badge bg-success">Active</span>`;
                        } else {
                            statusBadge = `<span class="badge bg-danger">Inactive</span>`;
                        }
                        $('#example3 tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.studentName}</td>
                                <td>${row.studentEmail}</td>
                                <td>${row.studentBatch}</td>
                                <td>${row.studentGroup}</td>
                                <td>${statusBadge}</td>
                                <td>${row.create_date}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-primary shadow btn-xs sharp me-1 edit-student" data-studentid="${row.id}" data-studentname="${row.studentName}" data-studentemail="${row.studentEmail}" data-studentbatchid="${row.studentBatchId}" data-studentgroupid="${row.studentGroupId}" data-isactive="${row.isActive}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn btn-danger shadow btn-xs sharp delete-student" data-studentid="${row.id}">
                                            <i class="fa fa-trash"></i>
                                        </button>
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

    // Load students
    readStudents();

    // Load batches for select2
    $.ajax({
        url: '../apis/batchesApi.php',
        type: 'POST',
        data: { action: 'getBatches' },
        dataType: 'json',
        success: function(response) {
            var options = '<option value="">Select Batch</option>';
            if (response.status === 'success' && response.message === 'No batches found') {
                options = '<option value="">No batches found</option>';
            } else {
                $.each(response, function(i, batch) {
                    options += '<option value="' + batch.id + '">' + batch.batchName + '</option>';
                });
            }
            $('#studentBatch').html(options);
            $('#editStudentBatch').html(options);

            // Initialize select2
            $('#studentBatch').select2({
                dropdownParent: $('#addStudentModal'),
                width: '100%'
            });
            $('#editStudentBatch').select2({
                dropdownParent: $('#editStudentModal'),
                width: '100%'
            });
        }
    });

    // Load groups for select2
    $.ajax({
        url: '../apis/groupsApi.php',
        type: 'POST',
        data: { action: 'getGroups' },
        dataType: 'json',
        success: function(response) {
            var options = '<option value="">Select Group</option>';
            if (response.status === 'success' && response.message === 'No groups found') {
                options = '<option value="">No groups found</option>';
            } else {
                $.each(response, function(i, group) {
                    options += '<option value="' + group.id + '">' + group.groupName + '</option>';
                });
            }
            $('#studentGroup').html(options);
            $('#editStudentGroup').html(options);

            // Initialize select2
            $('#studentGroup').select2({
                dropdownParent: $('#addStudentModal'),
                width: '100%'
            });
            $('#editStudentGroup').select2({
                dropdownParent: $('#editStudentModal'),
                width: '100%'
            });
        }
    });

    // Insert
    $(document).on("submit", "#addStudentForm", function(e) {
        e.preventDefault();

        // Form validation
        let studentName = $("#studentName").val();
        let studentEmail = $("#studentEmail").val();
        let studentBatch = $("#studentBatch").val();
        let studentGroup = $("#studentGroup").val();
        let studentPassword = $("#studentPassword").val();
        let isActive = $("#isActive").val();

        if (studentName == "" || studentEmail == "" || studentBatch == "" || studentGroup == "" || studentPassword == "" || isActive == "") {
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
        formData.append("action", "addStudent");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/studentsApi.php",
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
                        // Load students
                        readStudents();
                    });
                }

            }
        });

    });

    // Edit Student
    $(document).on("click", ".edit-student", function() {
        let studentId = $(this).data("studentid");
        let studentName = $(this).data("studentname");
        let studentEmail = $(this).data("studentemail");
        let studentBatchId = $(this).data("studentbatchid");
        let studentGroupId = $(this).data("studentgroupid");
        let isActive = $(this).data("isactive");

        $("#editStudentId").val(studentId);
        $("#editStudentName").val(studentName);
        $("#editStudentEmail").val(studentEmail);
        $("#editStudentBatch").val(studentBatchId).trigger('change');
        $("#editStudentGroup").val(studentGroupId).trigger('change');
        $("#editIsActive").val(isActive);

        // Open the update modal
        $("#editStudentModal").modal("show");
    });

    $(document).on("submit", "#editStudentForm", function(e) {
        e.preventDefault();

        // Form validation
        let studentName = $("#editStudentName").val();
        let studentEmail = $("#editStudentEmail").val();
        let studentBatch = $("#editStudentBatch").val();
        let studentGroup = $("#editStudentGroup").val();
        let isActive = $("#editIsActive").val();
        let studentId = $("#editStudentId").val();

        if (studentName == "" || studentEmail == "" || studentBatch == "" || studentGroup == "" || isActive == "") {
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
        formData.append("action", "updateStudent");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/studentsApi.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // Close the modal
                $("#editStudentModal").modal("hide");

                Swal.fire({
                    title: response.status,
                    text: response.message,
                    icon: response.status.toLowerCase(),
                    confirmButtonText: "OK"
                }).then(() => {
                    // Load students
                    readStudents();
                });
            }
        });

    });

    // Delete Student
    $(document).on("click", ".delete-student", function() {
        let studentId = $(this).data("studentid");

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
                    url: "../apis/studentsApi.php",
                    data: { action: "deleteStudent", id: studentId },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: response.status,
                            text: response.message,
                            icon: response.status.toLowerCase(),
                            confirmButtonText: "OK"
                        }).then(() => {
                            // Load students
                            readStudents();
                        });
                    }
                });
            }
        });
    });

});
