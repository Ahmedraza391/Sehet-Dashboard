$(document).ready(function () {
    // function for_disabled_right_click(){
    //     document.addEventListener('contextmenu', function(e) {
    //         e.preventDefault();
    //     });
    //     document.addEventListener('keydown', function(e) {
    //         if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.keyCode === 73))) {
    //             e.preventDefault();
    //         }
    //     });
    // }
    // for_disabled_right_click();
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
        // For Inserting / Updating / Deleting / Retrieving = Province 
        function province_func() {
            fetch_province();
            // For Insert / Add Province
            $("#insert_province_form").on("submit", function (e) {
                e.preventDefault();
                let Province = $("#province").val();
                if (Province === "") {
                    alert("Province name cannot be empty");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "insert_province.php",
                    data: { province: Province },
                    success: function (res) {
                        $('#add_province').modal('hide');
                        $("#insert_province_form").trigger("reset");
                        alert_box("Province Added Successfully", "Address Management");
                        fetch_province();
                    },
                    error: function (res) {
                        alert_box("Error in submission", "Error");
                        console.error(res);
                    }
                });
            });
            // For Edit Province
            $(document).on('click', '.edit-province', function () {
                const province_id = $(this).data('id');
                const province = $(this).data('province');

                $('#edit_province_Id').val(province_id);
                $('#edit_province').val(province);

                $('#edit_province_modal').modal('show');
            });
            $('#editprovinceForm').on('submit', function (e) {
                e.preventDefault();

                const province_id = $('#edit_province_Id').val();
                const province_name = $('#edit_province').val();

                $.ajax({
                    type: 'POST',
                    url: 'update_province.php',
                    data: { id: province_id, province: province_name },
                    success: function (response) {
                        alert_box("Province Updated Successfully", "Address Management");
                        $('#edit_province_modal').modal('hide');
                        fetch_province();
                    },
                    error: function () {
                        alert('Failed to Update Province');
                    }
                });
            });
            // For Delete Province
            $(document).on('click', '.delete-province', function () {
                const province_id = $(this).data('id');
                const confirmation = confirm('Are you sure you want to delete this Province?');

                if (confirmation) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_province.php',
                        data: { id: province_id },
                        success: function (response) {
                            alert_box("Province Deleted Successfully", "Address Management")
                            fetch_province();
                        },
                        error: function () {
                            alert('Failed to Delete Province');
                        }
                    });
                }
            });
            // For Fetch Province
            function fetch_province() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_province.php',
                    success: function (response) {
                        $('#provinceTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch Province');
                    }
                });
            }
        }
        province_func();
        // For Inserting / Updating / Deleting / Retrieving = City
        function city_func() {
            fetchcity();
            // For Insert / Add City
            $("#insert_city_form").on("submit", function (e) {
                e.preventDefault();
                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "insert_city.php",
                    data: formdata,
                    success: function (res) {
                        $("#add_city").modal("hide");
                        $("#insert_city_form").trigger("reset");
                        alert_box("City Added Successfully", "Address Management");
                        fetchcity();
                    }, error: function () {

                    }
                })
            })
            // For Edit city
            $(document).on('click', '.edit-city', function () {
                let cityId = $(this).data("id");
                let cityName = $(this).data("city");
                let province_id = $(this).data("province");
                $('#city_id').val(cityId);
                $('#city').val(cityName);
                $.ajax({
                    type: "POST",
                    url: "province_option.php",
                    data: { id: province_id },
                    success: function (response) {
                        $("#province_menu").html(response);
                    }
                })
                $('#edit_city_modal').modal('show');
            });
            $('#editcityForm').on('submit', function (e) {
                e.preventDefault();
                let edit_form_data = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'update_city.php',
                    data: edit_form_data,
                    success: function (response) {
                        $('#edit_city_modal').modal('hide');
                        $("#editcityForm").trigger("reset");
                        alert_box("City Updated Successfully", "Address Management");
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
                            fetchcity();
                            alert_box("City Deleted Successfully", "Address Management")
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
        city_func();
        // For Inserting / Updating / Deleting / Retrieving = Capital-Area 
        function city_area() {
            fetch_city_area();
            // For Insert / Add Capital Area
            $("#insert_capital_area_form").on("submit", function (e) {
                e.preventDefault();
                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "insert_city_area.php",
                    data: formdata,
                    success: function (res) {
                        $("#add_city_area").modal("hide");
                        $("#insert_capital_area_form").trigger("reset");
                        alert_box("Area Added Successfully", "Address Management");
                        fetch_city_area();
                    }, error: function () {
                        alert("Failed To Insert Area")
                    }
                })
            })

            // For Edit Capital Area
            $(document).on('click', '.edit-capital-area', function () {
                let capitalAreaId = $(this).data("id");
                let capitalAreaName = $(this).data("area");
                let city_id = $(this).data("city");
                $('#area_id').val(capitalAreaId);
                $('#area_name').val(capitalAreaName);
                $.ajax({
                    type: "POST",
                    url: "capital_area_option.php",
                    data: { id: city_id },
                    success: function (response) {
                        $("#city_menu").html(response);
                    }
                })
                $('#editCapitalAreaModal').modal('show');
            });
            $('#editcityareaForm').on('submit', function (e) {
                e.preventDefault();
                let edit_form_data = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'update_capital_area.php',
                    data: edit_form_data,
                    success: function (response) {
                        $('#editCapitalAreaModal').modal('hide');
                        alert_box("Area Updated Successfully", "Addresses Management");
                        fetch_city_area();
                    },
                    error: function () {
                        alert('Failed to Update Area');
                    }
                });
            });
            // For Delete Capital Area
            $(document).on('click', '.delete-capital-area', function () {
                const capital_area_id = $(this).data('id');
                const confirmation = confirm('Are you sure you want to delete this Capital-Area?');
                if (confirmation) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_capital_area.php',
                        data: { id: capital_area_id },
                        success: function (response) {
                            fetch_city_area();
                            alert_box("Capital-Area Deleted Successfully", "Addresses Management")
                        },
                        error: function () {
                            alert('Failed to delete Capital-Area');
                        }
                    });
                }
            });
            function fetch_city_area() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_capital_area.php',
                    success: function (response) {
                        $('#cityareaTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch City Area');
                    }
                });
            }
        }
        city_area();
    }
    address_mangement();

    // For Reffrells Page
    function reffrels_management(){
        fetch_reffrals();
        // For Validate Numeber Input 
        $(".share").on("input", function() {
            var shareValue = parseFloat($(this).val());
            var errorElement = $(this).siblings(".error");

            if (isNaN(shareValue) || shareValue < 0 || shareValue > 100) {
                errorElement.text('Please enter a number between 0 and 100.');
            } else {
                errorElement.text('');
            }
        });
        // For Insert Reffral
        $("#reffral_form").on("submit", function(e) {
            e.preventDefault();
            var name = $("#ref_name").val();
            var email = $("#ref_email").val();
            var company = $("#ref_company").val();
            var share = $("#ref_share").val();
            $.ajax({
                url: "add_reffrals.php",
                type: "POST",
                data: {
                    ref_name : name,
                    ref_email : email,
                    ref_company : company,
                    ref_share : share
                },
                success: function(res) {
                    $("#reffral_modal").modal("hide");
                    alert_box('Reffral Added Successfully','Reffral Management');
                    $("#reffral_form")[0].reset(); 
                    fetch_reffrals();
                },
                error: function(xhr, status, error) {
                    alert('Error submitting form: ' + error);
                }
            });
        });
        // For Fetch Reffral Details in Modal
        $(document).on("click",".edit-reffral",function(){
            $("#editReffrals").modal("show");
            var id = $(this).data("id");
            var name = $(this).data("name");
            var company = $(this).data("company");
            var email = $(this).data("email");
            var share = $(this).data("share");
            var status = $(this).data("status");
            $("#reffral_id").val(id);
            $("#reffral_name").val(name);
            $("#reffral_company").val(company);
            $("#reffral_email").val(email);
            $("#reffral_share").val(share);
            $("#reffral_status").val(status);
        })
        // For Update / Edit Reffral
        $("#edit_reffrals_form").on("submit",function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url : "update_reffral.php",
                type : "POST",
                data : formData,
                success:function(res){
                    $("#editReffrals").modal("hide");
                    alert_box("Refferal Updated Successfully","Reffral Management");
                    fetch_reffrals();
                }
            })
        })
        // For Delete Reffral
        $(document).on('click', '.delete-reffral', function () {
            const id = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this Reffral?');
            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_reffral.php',
                    data: { id: id },
                    success: function (response) {
                        fetch_reffrals();
                        alert_box("Reffral Deleted Successfully", "Reffral Management")
                    },
                    error: function () {
                        alert('Failed to Delete Reffral');
                    }
                });
            }
        });
        // For View Reffral Details
        $(document).on("click",".view-reffrel",function(){
            $("#viewReffral").modal("show");
            var id = $(this).data("id");
            var name = $(this).data("name");
            var company = $(this).data("company");
            var email = $(this).data("email");
            var share = $(this).data("share");
            var status = $(this).data("status");
            $("#ref_id").html(id);
            $("#ref_name").html(name);
            $("#ref_company").html(company);
            $("#ref_email").html(email);
            $("#ref_share").html(share);
            $("#ref_status").html(status);
        })
        function fetch_reffrals(){
            $.ajax({
                url : "fetch_reffrals.php",
                type : "POST",
                success:function(res){
                    $("#reffralTable").html(res)
                }
            })
        }
        fetch_reffrals();
    }
    reffrels_management(); 

    // For

    // For Admin 
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