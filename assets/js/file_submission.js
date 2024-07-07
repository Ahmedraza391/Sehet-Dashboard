$(document).ready(function () {

    // For Services Page
    function Service_page_functions() {
        // For Inserting / Updating / Deleting / Retrieving = Services 
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
                        $("#insert_service_form").trigger("reset");
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
                        $("#editserviceForm").trigger("reset");
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
        // For Inserting / Updating / Deleting / Retrieving = Sub Services 
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
                        $("#insert_sub_service_form").trigger("reset");
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
        // For Inserting / Updating / Deleting / Retrieving = Extra Services 
        function extra_service_function() {
            fetchExtraServices();
            // For Insert / Add Extra-Services
            $("#insert_extra_service_form").on("submit", function (e) {
                e.preventDefault();

                var formdata = $(this).serialize();
                var submitButton = $(this).find('button[type="submit"]');

                // Disable the submit button to prevent multiple submissions
                submitButton.prop("disabled", true);

                $.ajax({
                    type: "POST",
                    url: "insert_extra_services.php",
                    data: formdata,
                    success: function (res) {
                        submitButton.prop("disabled", false);
                        fetchExtraServices();
                        $("#add_extra_service").modal("hide");
                        $("#insert_extra_services").trigger("reset");
                        alert_box("Sub-Service Added Successfully", "Services");
                    },
                    error: function () {
                        alert_box("An error occurred while adding Sub-Service", "Error");
                        submitButton.prop("disabled", false);
                    }
                });
            });
            // For Edit Extra-Services
            $(document).on('click', '.edit-extra-service', function () {
                let extraserviceId = $(this).data("id");
                let extraserviceName = $(this).data("extraservice");
                let subserviceId = $(this).data("subserviceid");
                $('#edit_extra_ServiceId').val(extraserviceId);
                $('#edit_extra_service_name').val(extraserviceName);
                $.ajax({
                    type: "POST",
                    url: "extraservice_option.php",
                    data: { id: subserviceId },
                    success: function (response) {
                        $("#edit_sub_service_id").html(response);
                    }
                })
                $('#editextraServicesModal').modal('show');
            });
            // For Updating Extra-Services
            $('#editExtraServices').on('submit', function (e) {
                e.preventDefault();
                let edit_form_data = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'update_extra_services.php',
                    data: edit_form_data,
                    success: function (response) {
                        $('#editextraServicesModal').modal('hide');
                        alert_box("Extra-Service Updated Successfully", "Services");
                        fetchExtraServices();
                    },
                    error: function () {
                        alert('Failed to update service');
                    }
                });
            });
            // For Delete Extra-Services
            $(document).on('click', '.delete-extra-service', function () {
                const extra_service_id = $(this).data('id');
                const confirmation = confirm('Are you sure you want to delete this Extra-Service?');
                if (confirmation) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_extra_service.php',
                        data: { id: extra_service_id },
                        success: function (response) {
                            fetchExtraServices();
                            alert_box("Extra-Service Deleted Successfully", "Services")
                        },
                        error: function () {
                            alert('Failed to Delete Extra-Service');
                        }
                    });
                }
            });
            // For Fetch Extra-Services
            function fetchExtraServices() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_extra_services.php',
                    success: function (response) {
                        $('#extraServiceTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch services');
                    }
                });
            }
        }
        extra_service_function();
    }
    Service_page_functions();

    // For Address Management Page
    function address_mangement() {
        // For Inserting / Updating / Deleting / Retrieving = Services 
        function city_function() {
            fetchcity();
            // For Insert / Add City
            $("#insert_city_form").on("submit", function (e) {
                e.preventDefault();
                let city = $("#city").val();
                if (city === "") {
                    alert("City name cannot be empty");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "insert_city.php",
                    data: { cty: city },
                    success: function (res) {
                        $('#add_city').modal('hide');
                        $("#insert_city_form").trigger("reset");
                        alert_box("City Added Successfully", "Address Management");
                        fetchcity();
                    },
                    error: function (res) {
                        alert_box("Error in submission", "Error");
                        console.error(res);
                    }
                });
            });
            // For Edit City
            $(document).on('click', '.edit-city', function () {
                const cityid = $(this).data('id');
                const cityName = $(this).data('city');

                $('#edit_city_Id').val(cityid);
                $('#editCityName').val(cityName);

                $('#editCityModal').modal('show');
            });
            $('#editcityForm').on('submit', function (e) {
                e.preventDefault();

                const city_id = $('#edit_city_Id').val();
                const city_name = $('#editCityName').val();

                $.ajax({
                    type: 'POST',
                    url: 'update_city.php',
                    data: { id: city_id, city: city_name },
                    success: function (response) {
                        alert_box("City Updated Successfully", "Address Management");
                        $('#editCityModal').modal('hide');
                        fetchcity();
                    },
                    error: function () {
                        alert('Failed to Update City');
                    }
                });
            });
            // For Delete City
            $(document).on('click', '.delete-city', function () {
                const city_id = $(this).data('id');
                const confirmation = confirm('Are you sure you want to delete this City?');

                if (confirmation) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_city.php',
                        data: { id: city_id },
                        success: function (response) {
                            alert_box("City Deleted Successfully", "Address Management")
                            fetchcity();
                        },
                        error: function () {
                            alert('Failed to Delete City');
                        }
                    });
                }
            });
            // For Fetch City
            function fetchcity() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_city.php',
                    success: function (response) {
                        $('#cityTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch services');
                    }
                });
            }
        }
        city_function();

        function city_capital(){
            fetchcitycapital();
            // For Insert / Add City Capital
            $("#insert_city_capital_form").on("submit", function (e) {
                e.preventDefault();
                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "insert_city_capital.php",
                    data: formdata,
                    success: function (res) {
                        $("#add_city_capital").modal("hide");
                        $("#insert_city_capital_form").trigger("reset");
                        alert_box("City-Capital Added Successfully", "Address Management");
                        fetchcitycapital();
                    }, error: function () {

                    }
                })
            })
            // For Edit city-capital
            $(document).on('click', '.edit-city-capital', function () {
                let cityCapital_Id = $(this).data("id");
                let cityCapital_Name = $(this).data("capital");
                let CityId = $(this).data("city");
                alert(cityCapital_Name);
                $('#city_capital_id').val(cityCapital_Id);
                $('#city_capital').val(cityCapital_Name);
                $.ajax({
                    type: "POST",
                    url: "cityCapital_option.php",
                    data: { id: CityId },
                    success: function (response) {
                        $("#city_menu").html(response);
                    }
                })
                $('#editCityCapitalModal').modal('show');
            });
            $('#editcityCapitalForm').on('submit', function (e) {
                e.preventDefault();
                let edit_form_data = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'update_city_capital.php',
                    data: edit_form_data,
                    success: function (response) {
                        $('#editCityCapitalModal').modal('hide');
                        alert_box("Service Updated Successfully", "Services");
                        fetchSubServices();
                    },
                    error: function () {
                        alert('Failed to update service');
                    }
                });
            });
            // For Delete Sub-Services
            $(document).on('click', '.delete-city-capital', function () {
                const capital_id = $(this).data('id');
                const confirmation = confirm('Are you sure you want to delete this City-Capital?');
                if (confirmation) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_city_capital.php',
                        data: { id: capital_id },
                        success: function (response) {
                            fetchcitycapital();
                            alert_box("City-Capital Deleted Successfully", "Services")
                        },
                        error: function () {
                            alert('Failed to delete service');
                        }
                    });
                }
            });
            // For Fetch City
            function fetchcitycapital() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_city_capital.php',
                    success: function (response) {
                        $('#cityCapitalTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch services');
                    }
                });
            }
        }
        city_capital();
    }
    address_mangement();

    function admin_submission() {
        // For username 
        $(document).on("focusout", "#username", function () {
            var data = $(this).val();
            // Check if the input is not empty before sending the AJAX request
            if (data.trim() !== "") {
                $.ajax({
                    type: "POST",
                    url: "check_if_admin_exists.php",
                    data: { username: data },
                    success: function (response) {
                        $("#usernameFeedback").html(response);

                    },
                    error: function (response) {
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
                    alert('Account created successfully', 'Admin');
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