$(document).ready(function () {
 
// Read Data Request

function readBatches() {
    $.ajax({
        type: "POST",
        url: "../apis/batchesApi.php",
        data: { "action": "getBatches" },
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
                    
                    if (row.batchStatus === "Complete") {
                        statusBadge = `<span class="badge bg-success">Completed</span>`;
                    } else {
                        statusBadge = `<span class="badge bg-warning text-dark">Ongoing</span>`;
                    }
                    $('#example3 tbody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${row.batchName}</td>
                            <td>${row.batchStartDate}</td>
                            <td>${statusBadge}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-primary shadow btn-xs sharp me-1 edit-batch" data-batchid="${row.batchId}" data-batchname="${row.batchName}" data-batchstartdate="${row.batchStartDate}" data-batchstatus="${row.batchStatus}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger shadow btn-xs sharp delete-batch" data-batchid="${row.batchId}">
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

// Load batches 
readBatches();


// Insert
$(document).on("submit","#insertForm",function(e)
{
    e.preventDefault();

    // Form validation
    let batchName = $("#batchName").val();
    let batchStartDate = $("#batchStartDate").val();
    let batchStatus = $("#batchStatus").val();

    if (batchName == "" || batchStartDate == "" || batchStatus == "") {
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
    formData.append("action","insertBatches")

    // Ajax Logic
    $.ajax({
        type: "POST",
        url: "../apis/batchesApi.php",
        data: formData,
        processData:false,
        contentType:false,
        dataType: "json",
        success: function (response) {
          if(response.status == "error")
            { 
            Swal.fire({
            title: response.status,        // e.g., "Success" or "Error"
            text: response.message,        // e.g., "Batch added successfully"
            icon: response.status.toLowerCase(), // "success", "error", etc.
            confirmButtonText: "OK"
            });
        }
        else if(response.status == "success")
        {
           Swal.fire({
            title: response.status,        // e.g., "Success" or "Error"
            text: response.message,        // e.g., "Batch added successfully"
            icon: response.status.toLowerCase(), // "success", "error", etc.
            confirmButtonText: "OK"
            }).then(()=>
            {
                // Load batches 
                readBatches();
                // Reset The Form 
                $("#insertForm")[0].reset();
                
            });
            }

        }
    });

});

// Update Batch
$(document).on("click", ".edit-batch", function() {
    let batchId = $(this).data("batchid");
    let batchName = $(this).data("batchname");
    let batchStartDate = $(this).data("batchstartdate");
    let batchStatus = $(this).data("batchstatus");

    $("#updateBatchId").val(batchId);
    $("#updateBatchName").val(batchName);
    $(".updateMdate").val(batchStartDate);

    // Set the radio button based on the batchStatus value
    if (batchStatus === "Complete") {
        $("#updateBatchStatusComplete").prop("checked", true);
    } else if (batchStatus === "Ongoing") {
        $("#updateBatchStatusOngoing").prop("checked", true);
    }

    // Open the update modal
    $("#updateModal").modal("show");
});

$(document).on("submit", "#updateForm", function(e) {
    e.preventDefault();

    // Form validation
    let batchName = $("#updateBatchName").val();
    let batchStartDate = $("#updateMdate").val();
    let batchStatus = $("input[name='batchStatus']:checked").val();
    let batchId = $("#updateBatchId").val();

    if (batchName == "" || batchStartDate == "" || batchStatus == "") {
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
    formData.append("action", "updateBatches");

    // Ajax Logic
    $.ajax({
        type: "POST",
        url: "../apis/batchesApi.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(response) {
            // Close the modal
            $("#updateModal").modal("hide");

            Swal.fire({
                title: response.status,
                text: response.message,
                icon: response.status.toLowerCase(),
                confirmButtonText: "OK"
            }).then(() => {
                // Load batches
                readBatches();
            });
        }
    });

});

// Delete Batch
$(document).on("click", ".delete-batch", function() {
    let batchId = $(this).data("batchid");

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
                url: "../apis/batchesApi.php",
                data: { action: "deleteBatches", batchId: batchId },
                dataType: "json",
                success: function (response) {
                    Swal.fire({
                        title: response.status,
                        text: response.message,
                        icon: response.status.toLowerCase(),
                        confirmButtonText: "OK"
                    }).then(() => {
                        // Load batches
                        readBatches();
                    });
                }
            });
        }
    });
});

// Insert Button Loading
$(document).on("submit", "#insertForm", function(e) {
    e.preventDefault();

    // Disable the submit button and show loading spinner
    let submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

    // Form validation
    let batchName = $("#batchName").val();
    let batchStartDate = $("#batchStartDate").val();
    let batchStatus = $("#batchStatus").val();

    if (batchName == "" || batchStartDate == "" || batchStatus == "") {
        Swal.fire({
            title: "Error",
            text: "Please fill in all fields",
            icon: "error",
            confirmButtonText: "OK"
        }).then(() => {
            // Re-enable the submit button
            submitButton.prop('disabled', false).html('Submit');
        });
        return;
    }

    // Storing form Data
    let formData = new FormData(this);

    // Action
    formData.append("action", "insertBatches");

    // Ajax Logic
    $.ajax({
        type: "POST",
        url: "../apis/batchesApi.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(response) {
            // Re-enable the submit button and remove loading spinner
            submitButton.prop('disabled', false).html('Submit');

            if (response.status == "error") {
                Swal.fire({
                    title: response.status, // e.g., "Success" or "Error"
                    text: response.message, // e.g., "Batch added successfully"
                    icon: response.status.toLowerCase(), // "success", "error", etc.
                    confirmButtonText: "OK"
                });
            } else if (response.status == "success") {
                Swal.fire({
                    title: response.status, // e.g., "Success" or "Error"
                    text: response.message, // e.g., "Batch added successfully"
                    icon: response.status.toLowerCase(), // "success", "error", etc.
                    confirmButtonText: "OK"
                }).then(() => {
                    // Load batches
                    readBatches();
                    // Reset The Form
                    $("#insertForm")[0].reset();

                });
            }

        },
        error: function() {
            // Re-enable the submit button and remove loading spinner in case of error
            submitButton.prop('disabled', false).html('Submit');
            Swal.fire({
                title: "Error",
                text: "An error occurred during the AJAX request.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });

});


// Doc Rady Close
});
