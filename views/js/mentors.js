$(document).ready(function() {

    // Read Data Request
    function readMentors() {
        $.ajax({
            type: "POST",
            url: "../apis/mentorsApi.php",
            data: { "action": "getMentors" },
            dataType: "json",
            success: function (response) {
                console.log("Response data:", response);
                if (Array.isArray(response)) {
                    // Destroy existing DataTable if it exists
                    if ($.fn.DataTable.isDataTable("#example3")) {
                        $('#example3').DataTable().destroy();
                    }

                    // Clear existing rows
                    $('#example3 tbody').empty();

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
                                <td>${row.mentorName}</td>
                                <td>${row.mentorEmail}</td>
                                <td>${row.mentorGroup}</td>
                                <td>${statusBadge}</td>
                                <td>${row.create_date}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-primary shadow btn-xs sharp me-1 edit-mentor" data-mentorid="${row.id}" data-mentorname="${row.mentorName}" data-mentoremail="${row.mentorEmail}" data-isactive="${row.isActive}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn btn-danger shadow btn-xs sharp delete-mentor" data-mentorid="${row.id}">
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

    // Load mentors
    readMentors();

    // Insert
    $(document).on("submit", "#addMentorForm", function(e) {
        e.preventDefault();

        // Form validation
        let mentorName = $("#mentorName").val();
        let mentorEmail = $("#mentorEmail").val();
        let mentorPassword = $("#mentorPassword").val();
        let isActive = $("#isActive").val();

        if (mentorName == "" || mentorEmail == "" || mentorPassword == "" || isActive == "") {
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
        formData.append("action", "addMentor");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/mentorsApi.php",
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
                        // Load mentors
                        readMentors();
                    });
                }

            }
        });

    });

    // Edit Mentor
    $(document).on("click", ".edit-mentor", function() {
        let mentorId = $(this).data("mentorid");
        let mentorName = $(this).data("mentorname");
        let mentorEmail = $(this).data("mentoremail");
        let isActive = $(this).data("isactive");

        $("#editMentorId").val(mentorId);
        $("#editMentorName").val(mentorName);
        $("#editMentorEmail").val(mentorEmail);
        $("#editIsActive").val(isActive);

        // Open the update modal
        $("#editMentorModal").modal("show");
    });

    $(document).on("submit", "#editMentorForm", function(e) {
        e.preventDefault();

        // Form validation
        let mentorName = $("#editMentorName").val();
        let mentorEmail = $("#editMentorEmail").val();
        let isActive = $("#editIsActive").val();
        let mentorId = $("#editMentorId").val();

        if (mentorName == "" || mentorEmail == "" || isActive == "") {
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
        formData.append("action", "updateMentor");

        // Ajax Logic
        $.ajax({
            type: "POST",
            url: "../apis/mentorsApi.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // Close the modal
                $("#editMentorModal").modal("hide");

                Swal.fire({
                    title: response.status,
                    text: response.message,
                    icon: response.status.toLowerCase(),
                    confirmButtonText: "OK"
                }).then(() => {
                    // Load mentors
                    readMentors();
                });
            }
        });

    });

    // Delete Mentor
    $(document).on("click", ".delete-mentor", function() {
        let mentorId = $(this).data("mentorid");

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
                    url: "../apis/mentorsApi.php",
                    data: { action: "deleteMentor", id: mentorId },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: response.status,
                            text: response.message,
                            icon: response.status.toLowerCase(),
                            confirmButtonText: "OK"
                        }).then(() => {
                            // Load mentors
                            readMentors();
                        });
                    }
                });
            }
        });
    });

});
