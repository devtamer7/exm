$(document).ready(function () {
    $(document).on("submit", "#addFormStudent", function(e){
        e.preventDefault();

        let formdata = new FormData(this);
        formdata.append("action", "registerF");
        formdata.append("registerF", "Exercise123");

        $.ajax({
            type: "POST",
            url: "apis/register_api.php",
            data: formdata,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                console.log(response); 

                if (response.status == "success") {    
                    Swal.fire({
                        title: "Good job!",
                        text: response.message + " | ID: " + response.id, 
                        icon: "success"
                    });
                    $("#addFormStudent")[0].reset();
                } else if (response.status == "error") {
                    Swal.fire({
                        title: "I Am Sorry!",
                        text: response.message,
                        icon: "error"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error); 
            }
        });
    });
});
