$(document).ready(function() {
    // Initialize Select2 for Batch and Group dropdowns
    $('#studentBatch').select2({
        placeholder: "Select Batch",
        allowClear: true,
        dropdownParent: $('body') // Ensure dropdown renders correctly
    });

    $('#studentGroup').select2({
        placeholder: "Select Group",
        allowClear: true,
        dropdownParent: $('body') // Ensure dropdown renders correctly
    });

    // Populate Batch dropdown
    $.ajax({
        url: '../apis/batchesapi.php',
        type: 'POST',
        data: { action: 'getBatches' },
        dataType: 'json',
        success: function(data) {
            if (data.status !== 'error') { // Assuming 'error' status indicates no data or an issue
                $('#studentBatch').empty().append('<option value="">Select Batch</option>');
                $.each(data, function(key, value) {
                    $('#studentBatch').append('<option value="' + value.id + '">' + value.batchName + '</option>');
                });
            } else {
                displayAlert('Error loading batches: ' + data.message, 'danger');
            }
        },
        error: function(xhr, status, error) {
            displayAlert('AJAX error loading batches: ' + error, 'danger');
        }
    });

    // Populate Group dropdown
    $.ajax({
        url: '../apis/groupsapi.php',
        type: 'POST',
        data: { action: 'getGroups' },
        dataType: 'json',
        success: function(data) {
            if (data.status !== 'error') { // Assuming 'error' status indicates no data or an issue
                $('#studentGroup').empty().append('<option value="">Select Group</option>');
                $.each(data, function(key, value) {
                    $('#studentGroup').append('<option value="' + value.id + '">' + value.groupName + '</option>');
                });
            } else {
                displayAlert('Error loading groups: ' + data.message, 'danger');
            }
        },
        error: function(xhr, status, error) {
            displayAlert('AJAX error loading groups: ' + error, 'danger');
        }
    });

    // Frontend validation for the registration form
    $('#studentRegistrationForm').validate({
        rules: {
            studentName: {
                required: true,
                minlength: 3
            },
            studentEmail: {
                required: true,
                email: true
            },
            studentBatch: {
                required: true
            },
            studentGroup: {
                required: true
            },
            studentPassword: {
                required: true,
                minlength: 6
            },
            confirmPassword: {
                required: true,
                minlength: 6,
                equalTo: "#studentPassword"
            }
        },
        messages: {
            studentName: {
                required: "Please enter a student name",
                minlength: "Student name must be at least 3 characters long"
            },
            studentEmail: {
                required: "Please enter a student email",
                email: "Please enter a valid email address"
            },
            studentBatch: {
                required: "Please select a batch"
            },
            studentGroup: {
                required: "Please select a group"
            },
            studentPassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            confirmPassword: {
                required: "Please confirm your password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            }
        },
        showErrors: function(errorMap, errorList) {
            const alertMessage = $('#alertMessage');
            alertMessage.removeClass('alert-success').addClass('alert-danger');
            if (errorList.length > 0) {
                let errorMessage = '';
                $.each(errorList, function(index, error) {
                    errorMessage += error.message + '<br>';
                });
                alertMessage.html(errorMessage).css('display', 'block');
            } else {
                alertMessage.css('display', 'none').html('');
            }
            this.defaultShowErrors(); // Call default method to show individual field errors (if any)
        },
        submitHandler: function(form) {
            // Clear previous alerts before submission
            $('#alertMessage').css('display', 'none').html('').removeClass('alert-success alert-danger');

            // Handle form submission via AJAX
            var formData = $(form).serializeArray();
            formData.push({name: 'action', value: 'registerStudent'}); // Add action for studentsapi.php

            $.ajax({
                url: '../apis/studentsapi.php', // Use studentsapi.php for registration
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        displayAlert(response.message, 'success');
                        form.reset(); // Clear the form
                        // Reset Select2 dropdowns visually
                        $('#studentBatch').val(null).trigger('change');
                        $('#studentGroup').val(null).trigger('change');
                    } else {
                        displayAlert(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    displayAlert('An error occurred during registration. Please try again.', 'danger');
                }
            });
            return false; // Prevent default form submission
        }
    });

    function displayAlert(message, type) {
        const alertMessage = $('#alertMessage');
        alertMessage.removeClass('alert-success alert-danger').addClass('alert-' + type).html(message).css('display', 'block');
    }
});