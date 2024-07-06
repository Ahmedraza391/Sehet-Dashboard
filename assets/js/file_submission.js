$(document).ready(function () {
    function service_function() {
        fetchServices();
        // For Insert / Add Services
        $("#insert_service_form").on("submit", function (e) {
            e.preventDefault();
            var service = $("#serivce").val();
            $.ajax({
                type: "POST",
                url: "insert_service.php",
                data: { service: service },
                success: function (res) {
                    $('#add_service').modal('hide');
                    alert_box("Service Added Successfully", "Services");
                    fetchServices();
                }
            })
        })
        // For Edit Services
        $(document).on('click', '.edit-service', function () {
            const serviceId = $(this).data('id');
            const serviceName = $(this).data('service');

            $('#edit_ServiceId').val(serviceId);
            $('#edit_ServiceName').val(serviceName);

            $('#editServiceModal').modal('show');
        });
        $('#editserviceForm').on('submit', function (e) {
            e.preventDefault();

            const serviceId = $('#edit_ServiceId').val();
            const serviceName = $('#edit_ServiceName').val();

            $.ajax({
                type: 'POST',
                url: 'update_service.php',
                data: { id: serviceId, service: serviceName },
                success: function (response) {
                    alert_box("Service Updated Successfully", "Services");
                    $('#editServiceModal').modal('hide');
                    fetchServices();
                },
                error: function () {
                    alert('Failed to update service');
                }
            });
        });
        // For Delete Services
        $(document).on('click', '.delete-service', function () {
            const serviceId = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this service?');

            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_service.php',
                    data: { id: serviceId },
                    success: function (response) {
                        alert_box("Service Deleted Successfully", "Services")
                        fetchServices();
                    },
                    error: function () {
                        alert('Failed to delete service');
                    }
                });
            }
        });
        // For Fetch Services
        function fetchServices() {
            $.ajax({
                type: 'GET',
                url: 'fetch_services.php',
                success: function (response) {
                    $('#serviceTable').html(response);
                },
                error: function () {
                    alert('Failed to fetch services');
                }
            });
        }
    }
    service_function();
    function sub_service_function() {
        fetchSubServices();
        // For Insert / Add Sub-Services
        $("#insert_sub_service_form").on("submit", function (e) {
            e.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "insert_sub_services.php",
                data: formdata,
                success: function (res) {
                    $("#add_sub_service").modal("hide");
                    alert_box("Sub-Service Added Successfully", "Services");
                    fetchSubServices();
                }, error: function () {

                }
            })
        })
        // For Edit Sub-Services
        $(document).on('click', '.edit-sub-service', function () {
            let subserviceId = $(this).data("id");
            let subserviceName = $(this).data("subservice");
            let serviceId = $(this).data("serviceid");

            $('#edit_SubServiceId').val(subserviceId);
            $('#edit_service_name').val(subserviceName);
            $.ajax({
                type: "POST",
                url: "subservice_option.php",
                data: { id: serviceId },
                success: function (response) {
                    $("#edit_service_id").html(response);
                }
            })
            $('#editSubServicesModal').modal('show');
        });
        $('#editSubServices').on('submit', function (e) {
            e.preventDefault();
            let edit_form_data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'update_sub_services.php',
                data: edit_form_data,
                success: function (response) {
                    $('#editSubServicesModal').modal('hide');
                    alert_box("Service Updated Successfully", "Services");
                    fetchSubServices();
                },
                error: function () {
                    alert('Failed to update service');
                }
            });
        });
        // For Delete Sub-Services
        $(document).on('click', '.delete-sub-service', function () {
            const sub_service_id = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this sub-service?');

            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_sub_service.php',
                    data: { id: sub_service_id },
                    success: function (response) {
                        fetchSubServices();
                        alert_box("Service Deleted Successfully", "Services")
                    },
                    error: function () {
                        alert('Failed to delete service');
                    }
                });
            }
        });
        // For Fetch Sub-Services
        function fetchSubServices() {
            $.ajax({
                type: 'GET',
                url: 'fetch_sub_services.php',
                success: function (response) {
                    $('#subServiceTable').html(response);
                },
                error: function () {
                    alert('Failed to fetch services');
                }
            });
        }
    }
    sub_service_function();
    function admin_submission() {
        // For username 
        $(document).on("focusout","#username", function() {
            var data = $(this).val();
            // Check if the input is not empty before sending the AJAX request
            if (data.trim() !== "") {
                $.ajax({
                    type: "POST",
                    url: "check_if_admin_exists.php",
                    data: { username: data },
                    success: function(response) {
                        $("#usernameFeedback").html(response);
                        
                    },
                    error: function(response) {
                        alert(response);
                    }
                });
            } else {
                $("#usernameFeedback").text("")
            }
        });
        // for Register Admin
        $('#registerForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting via the browser
            
            var formData = new FormData(this);

            $.ajax({
                url: 'admin_register_progress.php', // PHP script to handle form data
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert('Account created successfully','Admin');
                    window.location.href = "admin_login.php";
                },
                error: function () {
                    alert('Error in creating account');
                }
            });
        });
    }
    admin_submission()
    function alert_box(message, heading) {
        toastr.options.progressBar = true;
        toastr.options.timeOut = 3000;
        toastr.success(message, heading)
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 300;
        toastr.options.closeEasing = 'swing';
    }
})