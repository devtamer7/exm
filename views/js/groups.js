$(document).ready(function() {

    // Read Data Request
    function readGroups() {
        $.ajax({
            type: "POST",
            url: "../apis/groupsApi.php",
            data: { "action": "getGroups" },
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
                        $('#example3 tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.groupName}</td>
                                <td>${row.mentorName}</td>
                                <td>${row.create_date}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-primary shadow btn-xs sharp me-1 edit-group" data-groupid="${row.id}" data-groupname="${row.groupName}" data-groupmentorid="${row.groupMentor}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn btn-danger shadow btn-xs sharp delete-group" data-groupid="${row.id}">
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

    // Load groups
    readGroups();

    // Load mentors for select2
    $.ajax({
        url: '../apis/groupsApi.php',
        type: 'POST',
        data: { action: 'getMentors' },
        dataType: 'json',
        success: function(response) {
            var options = '<option value="">Select Mentor</option>';
            if (response.status === 'success' && response.message === 'No mentors found') {
                options = '<option value="">No mentors found</option>';
            } else {
                $.each(response, function(i, mentor) {
                    options += '<option value="' + mentor.id + '">' + mentor.mentorName + '</option>';
                });
            }
            $('#groupMentor').html(options);
            $('#editGroupMentor').html(options);

            // Initialize select2
            $('#groupMentor').select2({
                dropdownParent: $('#addGroupModal'),
                width: '100%'
            });
            $('#editGroupMentor').select2({
                dropdownParent: $('#editGroupModal'),
                width: '100%'
            });
        }
    });

    // Add mentor button click
    $(document).on("click", "#addMentorBtn", function() {
        $("#addMentorModal").modal("show");
    });


    // Insert
    $(document).on("submit", "#addGroupForm", function(e) {
        e.preventDefault();

        // Form validation
        let groupName = $("#groupName").val();
        let groupMentor = $("#groupMentor").val();

        if (groupName == "" || groupMentor == "") {
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
        formData.append("action", "addGroup");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/groupsApi.php",
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
                        // Load groups
                        readGroups();
                        // Reset The Form
                        $("#addGroupForm")[0].reset();
                        $('#addGroupModal').modal('hide');

                    });
                }

            }
        });

    });

    // Edit Group
    $(document).on("click", ".edit-group", function() {
        let groupId = $(this).data("groupid");
        let groupName = $(this).data("groupname");
        let groupMentorId = $(this).data("groupmentorid");

        $("#editGroupId").val(groupId);
        $("#editGroupName").val(groupName);
       $("#editGroupMentor").val(groupMentorId).trigger('change');
    

        // Open the update modal
        $("#editGroupModal").modal("show");
    });

    $(document).on("submit", "#editGroupForm", function(e) {
        e.preventDefault();

        // Form validation
        let groupName = $("#editGroupName").val();
        let groupMentor = $("#editGroupMentor").val();
        let groupId = $("#editGroupId").val();

        if (groupName == "" || groupMentor == "") {
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
        formData.append("action", "updateGroup");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/groupsApi.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // Close the modal
                $("#editGroupModal").modal("hide");

                Swal.fire({
                    title: response.status,
                    text: response.message,
                    icon: response.status.toLowerCase(),
                    confirmButtonText: "OK"
                }).then(() => {
                    // Load groups
                    readGroups();
                });
            }
        });

    });

    // Delete Group
    $(document).on("click", ".delete-group", function() {
        let groupId = $(this).data("groupid");

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
                    url: "../apis/groupsApi.php",
                    data: { action: "deleteGroup", id: groupId },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: response.status,
                            text: response.message,
                            icon: response.status.toLowerCase(),
                            confirmButtonText: "OK"
                        }).then(() => {
                            // Load groups
                            readGroups();
                        });
                    }
                });
            }
        });
    });

});
