$(document).ready(function() {
    // Function to fetch exercise counts for widgets
    function fetchExerciseCounts() {
        // Assuming a student_id is available, e.g., from a session or a hidden input
        // For now, using a placeholder student ID. In a real app, this would be dynamic.
        const studentId = $('#studentIdFile').val() || $('#studentIdGithub').val() || 1; // Placeholder

        $.ajax({
            url: '../apis/exercisesApi.php', // This API needs to be created
            type: 'GET',
            data: { action: 'getExerciseCounts', student_id: studentId },
            dataType: 'json',
            success: function(data) {
                $('#totalExercises').text(data.total || 0);
                $('#approvedExercises').text(data.approved || 0);
                $('#rejectedExercises').text(data.rejected || 0);

                // Update progress bars (simple example, can be more complex)
                const total = data.total || 1; // Avoid division by zero
                $('#approvedExercises').closest('.widget-stat').find('.progress-bar').css('width', ((data.approved || 0) / total * 100) + '%');
                $('#rejectedExercises').closest('.widget-stat').find('.progress-bar').css('width', ((data.rejected || 0) / total * 100) + '%');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching exercise counts:", status, error);
                toastr.error("Failed to load exercise counts.");
            }
        });
    }

    // Initialize Dropzone for file uploads
    if ($("#file-uploader").length) {
        Dropzone.autoDiscover = false; // Disable auto-discovery to manually initialize

        const fileUploader = new Dropzone("#file-uploader", {
            url: "../apis/exercisesApi.php?action=uploadExerciseFiles", // This API needs to be created
            paramName: "exercise_files", // The name that will be used to transfer the files
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            autoProcessQueue: false, // Do not upload files automatically
            uploadMultiple: true,
            parallelUploads: 10, // How many files to upload in parallel
            acceptedFiles: "image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/html,text/css,application/javascript,application/json,application/php,text/plain", // Allowed file types
            previewTemplate: `
                <div class="dz-preview dz-file-preview">
                    <div class="dz-image"><img data-dz-thumbnail /></div>
                    <div class="dz-details">
                        <div class="dz-filename"><span data-dz-name></span></div>
                        <div class="dz-size" data-dz-size></div>
                    </div>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                    <div class="dz-success-mark"><span>✔</span></div>
                    <div class="dz-error-mark"><span>✘</span></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                    <a class="dz-remove" href="javascript:undefined;" data-dz-remove>Remove file</a>
                    <input type="text" class="dz-filename-input" placeholder="Rename file" style="display:none;">
                </div>
            `,
            init: function() {
                const myDropzone = this;

                // Handle file renaming
                myDropzone.on("addedfile", function(file) {
                    const filenameSpan = file.previewElement.querySelector("[data-dz-name]");
                    const filenameInput = file.previewElement.querySelector(".dz-filename-input");

                    filenameSpan.addEventListener("click", function() {
                        filenameSpan.style.display = "none";
                        filenameInput.style.display = "block";
                        filenameInput.value = filenameSpan.textContent;
                        filenameInput.focus();
                    });

                    filenameInput.addEventListener("blur", function() {
                        filenameInput.style.display = "none";
                        filenameSpan.style.display = "block";
                        if (filenameInput.value.trim() !== "") {
                            file.name = filenameInput.value.trim();
                            filenameSpan.textContent = file.name;
                        }
                    });

                    filenameInput.addEventListener("keypress", function(e) {
                        if (e.key === "Enter") {
                            filenameInput.blur();
                        }
                    });
                });

                // Handle form submission for file uploads
                $('#fileUploadForm').on('submit', function(e) {
                    e.preventDefault();
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue(); // Manually process the queue
                    } else {
                        // If no files are selected, submit the form data without files
                        submitFormData($(this), 'file');
                    }
                });

                myDropzone.on("sendingmultiple", function(file, xhr, formData) {
                    // Append all form data to the Dropzone formData
                    const form = $('#fileUploadForm');
                    form.find('input, select, textarea').each(function() {
                        formData.append($(this).attr('name'), $(this).val());
                    });
                    formData.append('type', 'file'); // Indicate it's a file upload
                });

                myDropzone.on("successmultiple", function(files, response) {
                    toastr.success("Exercise submitted successfully!");
                    $('#fileUploadForm')[0].reset(); // Reset form
                    myDropzone.removeAllFiles(true); // Clear Dropzone
                    fetchExerciseCounts(); // Refresh counts
                });

                myDropzone.on("errormultiple", function(files, response) {
                    toastr.error("Error submitting exercise: " + (response.message || "Unknown error"));
                    console.error("Dropzone error:", response);
                });
            }
        });
    }

    // Handle form submission for GitHub repo
    $('#githubUploadForm').on('submit', function(e) {
        e.preventDefault();
        submitFormData($(this), 'github_repo');
    });

    function submitFormData(form, type) {
        const formData = form.serializeArray();
        formData.push({ name: 'action', value: 'uploadExercise' });
        formData.push({ name: 'type', value: type });

        $.ajax({
            url: '../apis/exercisesApi.php', // This API needs to be created
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success("Exercise submitted successfully!");
                    form[0].reset(); // Reset form
                    fetchExerciseCounts(); // Refresh counts
                } else {
                    toastr.error("Error submitting exercise: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error submitting form:", status, error);
                toastr.error("Failed to submit exercise.");
            }
        });
    }

    // Initial fetch of exercise counts when the page loads
    fetchExerciseCounts();
});