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

    // For Show / Hide Password Functionality
    document.querySelectorAll('.togglePassword').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            var passwordInput = this.previousElementSibling; // Get the password input element
            var passwordIcon = this;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            }
        });
    });
    // For disabled Spinner button
    document.querySelectorAll('.no-spinner').forEach(function (input) {
        input.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
                event.preventDefault(); // Prevents arrow key changes
            }
        });

        // Disable mouse wheel changes
        input.addEventListener('wheel', function (event) {
            event.preventDefault(); // Prevents scroll changes
        });
    });
    // For Services Page
    function Service_page_functions() {
        // For Inserting / Updating / Deleting / Retrieving = Services 
        function service_function() {
            fetchServices();
            // For Insert / Add Services
            $("#insert_service_form").on("submit", function (e) {
                e.preventDefault();
                var service = $("#serivce").val();
                var changes_person = $("#changes_person").val();
                $.ajax({
                    type: "POST",
                    url: "insert_service.php",
                    data: { service: service, c_person: changes_person },
                    success: function (response) {
                        console.log(response);
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
                var changes_person = $("#changes_person").val();

                $.ajax({
                    type: 'POST',
                    url: 'update_service.php',
                    data: { id: serviceId, service: serviceName, c_person: changes_person },
                    success: function (response) {
                        console.log(response);
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
            // For Fetch Services
            function fetchServices() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_services.php',
                    success: function (response) {
                        console.log(response);
                        $('#serviceTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch services');
                    }
                });
            }
            fetchServices();
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
                    success: function (response) {
                        console.log(response);
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
                let subservicePrice = $(this).data("subservice_price");
                let serviceId = $(this).data("serviceid");

                $('#edit_SubServiceId').val(subserviceId);
                $('#edit_service_name').val(subserviceName);
                $('#edit_service_price').val(subservicePrice);
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
                        console.log(response);
                        $('#editSubServicesModal').modal('hide');
                        alert_box("Service Updated Successfully", "Services");
                        fetchSubServices();
                    },
                    error: function () {
                        alert('Failed to update service');
                    }
                });
            });
            // For Fetch Sub-Services
            function fetchSubServices() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_sub_services.php',
                    success: function (response) {
                        console.log(response);
                        $('#subServiceTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch services');
                    }
                });
            }
            fetchSubServices();
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
                    success: function (response) {
                        console.log(response);
                        submitButton.prop("disabled", false);
                        fetchExtraServices();
                        $("#add_extra_service").modal("hide");
                        $("#insert_extra_service_form").trigger("reset");
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
                let extraservicePrice = $(this).data("extraservice_price");
                let subserviceId = $(this).data("subserviceid");
                $('#edit_extra_ServiceId').val(extraserviceId);
                $('#edit_extra_service_name').val(extraserviceName);
                $('#edit_extra_service_price').val(extraservicePrice);
                $.ajax({
                    type: "POST",
                    url: "extraservice_option.php",
                    data: { id: subserviceId },
                    success: function (response) {
                        console.log(response);
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
                        console.log(response);
                        $('#editextraServicesModal').modal('hide');
                        alert_box("Extra-Service Updated Successfully", "Services");
                        fetchExtraServices();
                    },
                    error: function () {
                        alert('Failed to update service');
                    }
                });
            });
            // For Fetch Extra-Services
            function fetchExtraServices() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_extra_services.php',
                    success: function (response) {
                        console.log(response);
                        $('#extraServiceTable').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch services');
                    }
                });
            }
            fetchExtraServices();
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
                let change_person = $("#add_province_changes_person").val();
                if (Province === "") {
                    alert("Province name cannot be empty");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "insert_province.php",
                    data: { province: Province, c_person: change_person },
                    success: function (response) {
                        console.log(response);
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
                const changes_person = $("#edit_province_changes_person").val();

                $.ajax({
                    type: 'POST',
                    url: 'update_province.php',
                    data: { id: province_id, province: province_name, c_person: changes_person },
                    success: function (response) {
                        console.log(response);
                        alert_box("Province Updated Successfully", "Address Management");
                        $('#edit_province_modal').modal('hide');
                        fetch_province();
                    },
                    error: function () {
                        alert('Failed to Update Province');
                    }
                });
            });
            // For Fetch Province
            function fetch_province() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_province.php',
                    success: function (response) {
                        console.log(response);
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
                    success: function (response) {
                        console.log(response);
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
                        console.log(response);
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
                        console.log(response);
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
            // For Fetch City
            function fetchcity() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_city.php',
                    success: function (response) {
                        console.log(response);
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
                    success: function (response) {
                        console.log(response);
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
                        console.log(response);
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
                        console.log(response);
                        $('#editCapitalAreaModal').modal('hide');
                        alert_box("Area Updated Successfully", "Addresses Management");
                        fetch_city_area();
                    },
                    error: function () {
                        alert('Failed to Update Area');
                    }
                });
            });
            function fetch_city_area() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_capital_area.php',
                    success: function (response) {
                        console.log(response);
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
    function refferals_management() {
        fetch_reffrals();
        // For Validate Numeber Input 
        $(".share").on("input", function () {
            var shareValue = parseFloat($(this).val());
            var errorElement = $(this).siblings(".error");

            if (isNaN(shareValue) || shareValue < 0 || shareValue > 100) {
                errorElement.text('Please enter a number between 0 and 100.');
            } else {
                errorElement.text('');
            }
        });
        // For Insert Reffral
        $("#reffral_form").on("submit", function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "insert_refferals.php",
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log(response);
                    $("#reffral_modal").modal("hide");
                    alert_box('Reffral Added Successfully', 'Reffral Management');
                    $("#reffral_form")[0].reset();
                    fetch_reffrals();
                },
                error: function (xhr, status, error) {
                    alert('Error submitting form: ' + error);
                }
            });
        });
        // For Fetch Reffral Details in Modal
        $(document).on("click", ".edit-refferal", function () {
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
        $("#edit_reffrals_form").on("submit", function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "update_refferal.php",
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log(response);
                    $("#editReffrals").modal("hide");
                    alert_box("Refferal Updated Successfully", "Reffral Management");
                    fetch_reffrals();
                }
            })
        })
        // For Delete Reffral
        $(document).on('click', '.delete-refferal', function () {
            const id = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this Refferal?');
            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_refferal.php',
                    data: { id: id },
                    success: function (response) {
                        console.log(response);
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
        $(document).on("click", ".view-refferal", function () {
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
        function fetch_reffrals() {
            $.ajax({
                url: "fetch_reffrals.php",
                type: "POST",
                success: function (response) {
                    console.log(response);
                    $("#reffralTable").html(response)
                }
            })
        }
        fetch_reffrals();
    }
    refferals_management();

    // For Panel Page
    function panel_management() {
        fetch_panel();
        // for provinces cities changing functionality for both insert and edit
        // For Fetch Province in insert  Panel Modal
        $("#province").on("change", function () {
            let province = $(this).val();
            $.ajax({
                url: "panel_fetch_city_option.php",
                type: "POST",
                data: { id: province },
                success: function (response) {
                    console.log(response);
                    $("#city_id").html(response);
                    let city = $("#city_id").val();
                    $.ajax({
                        url: "panel_fetch_area_option.php",
                        type: "POST",
                        data: { id: city },
                        success: function (response) {
                            console.log(response);
                            $("#area_id").html(response);
                        }
                    });
                }
            });
        });
        // For Fetch City in insert  Panel Modal 
        $("#city_id").on("change", function () {
            let city = $(this).val();
            $.ajax({
                url: "panel_fetch_area_option.php",
                type: "POST",
                data: { id: city },
                success: function (response) {
                    console.log(response);
                    $("#area_id").html(response);

                    // Automatically select the first area in the list
                    let firstAreaOption = $("#area_id option:first").val();
                    $("#area_id").val(firstAreaOption).change(); // Trigger change event if needed
                }
            });
        });
        // For Fetch Province in Edit  Panel Modal 
        $("#edit_province").on("change", function () {
            let province = $(this).val();
            $.ajax({
                url: "panel_fetch_edit_city_option.php",
                type: "POST",
                data: { id: province },
                success: function (response) {
                    console.log(response);
                    $("#edit_vendor_city").html(response);
                    let city = $("#edit_city_id").val();
                    $.ajax({
                        url: "panel_fetch_edit_area_option.php",
                        type: "POST",
                        data: { id: city },
                        success: function (response) {
                            console.log(response);
                            $("#edit_area_id").html(response);
                        }
                    });
                }
            });
        });
        // For Fetch City in Edit  Panel Modal 
        $("#edit_city_id").on("change", function () {
            let city = $(this).val();
            $.ajax({
                url: "panel_fetch_edit_area_option.php",
                type: "POST",
                data: { id: city },
                success: function (response) {
                    console.log(response);
                    $("#edit_area_id").html(response);

                    // Automatically select the first area in the list
                    let firstAreaOption = $("#edit_area_id option:first").val();
                    $("#edit_area_id").val(firstAreaOption).change(); // Trigger change event if needed
                }
            });
        });
        // for provinces cities changing functionality for both insert and edit
        function validateForm() {
            var isValid = true;
            var subServicesSelected = {};
            var invalidSubServiceIds = [];
            var extraServicesErrors = [];

            // Check required fields
            $("#panel_form input[required], #panel_form select[required]").each(function () {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Collect selected sub-services
            $("#panel_form input[type='checkbox'][name='services[]']").each(function () {
                if ($(this).is(':checked')) {
                    var subServiceId = $(this).val();
                    subServicesSelected[subServiceId] = true;
                }
            });

            // Collect selected extra services and validate against selected sub-services
            $("#panel_form input[type='checkbox'][name^='extra_services']").each(function () {
                var subServiceId = $(this).attr('name').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    if (!subServicesSelected[subServiceId]) {
                        if (!invalidSubServiceIds.includes(subServiceId)) {
                            invalidSubServiceIds.push(subServiceId);
                        }
                        extraServicesErrors.push($(this).val());
                    }
                }
            });

            // Mark sub-services as invalid if extra services are selected without them
            invalidSubServiceIds.forEach(function (subServiceId) {
                $("#panel_form input[type='checkbox'][name='services[]'][value='" + subServiceId + "']").addClass('is-invalid');
            });

            // Show alert if there are any extra services selected without corresponding sub-services
            if (extraServicesErrors.length > 0) {
                isValid = false;
                alert('Please select the corresponding sub-services for the selected extra services.');
            }

            return isValid;
        }
        // for insert Data
        $("#panel_form").on("submit", function (e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            var formData = $(this).serialize();
            $.ajax({
                url: "insert_panel.php",
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log(response);
                    if (response === "Panel Inserted Successfully") {
                        $("#panel_modal").modal("hide");
                        fetch_panel();
                        alert_box("Panel Inserted Successfully", "Panel Management");
                        $("#panel_form")[0].reset();
                    } else {
                        alert("Unexpected response: " + response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
        // For fetch edit_modal panel
        $(document).on("click", ".edit-panel", function () {
            $("#editPanel").modal("show");

            let panel_id = $(this).data('id');
            $("#edit_panel_id").val(panel_id);
            $("#edit_panel_company").val($(this).data('company'));
            $("#edit_panel_manager").val($(this).data('manager'));
            $("#edit_panel_email").val($(this).data('email'));
            $("#edit_panel_contact").val($(this).data('contact'));
            $("#edit_panel_manager_contact").val($(this).data('manager_contact'));

            // Fetch Province, City, Area
            $.ajax({
                url: "panel_fetch_province_option.php",
                type: "POST",
                data: { id: $(this).data('province_id') },
                success: function (response) {
                    console.log(response);
                    $("#edit_province").html(response);
                },
                error: function (res) {
                    $("#edit_province").html("Error: " + res);
                }
            });
            $.ajax({
                url: "panel_fetch_city_sec_option.php",
                type: "POST",
                data: {
                    id: $(this).data('city_id'),
                    p_id: $(this).data('province_id')
                },
                success: function (response) {
                    console.log(response);
                    $("#edit_city_id").html(response);
                },
                error: function (res) {
                    $("#edit_city_id").html("Error: " + res);
                }
            });
            $.ajax({
                url: "panel_fetch_area_sec_option.php",
                type: "POST",
                data: {
                    id: $(this).data('area_id'),
                    c_id: $(this).data('city_id')
                },
                success: function (response) {
                    console.log(response);
                    $("#edit_area_id").html(response);
                },
                error: function (res) {
                    $("#edit_area_id").html("Error: " + res);
                }
            });
            $.ajax({
                url: "panel_fetch_services.php",
                type: "POST",
                data: { panel_id: panel_id },
                success: function (response) {
                    try {
                        let services = JSON.parse(response);
                        let servicesHtml = '';
                        
                        services.forEach(service => {
                            servicesHtml += `<div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="edit_panel_services[]" value="${service.sub_services_id}" id="service_${service.sub_services_id}" ${service.selected ? 'checked' : ''}>
                                                <label class="form-check-label" for="service_${service.sub_services_id}">${service.sub_service}---------${service.sub_services_original_price}</label>
                                                <input type="number" class="form-control no-spinner" name="edit_panel_service_prices[${service.sub_services_id}]" value="${service.sub_service_price}" placeholder="Enter Price">
                                             </div>`;
                            if (Object.keys(service.extra_services).length > 0) {
                                Object.values(service.extra_services).forEach(extraService => {
                                    servicesHtml += `<div class="form-check ms-md-5">
                                                        <input class="form-check-input" type="checkbox" name="edit_panel_extra_services[${service.sub_services_id}][]" value="${extraService.extra_services_id}" id="extra_service_${extraService.extra_services_id}" ${extraService.selected ? 'checked' : ''}>
                                                        <label class="form-check-label" for="extra_service_${extraService.extra_services_id}">${extraService.extra_service}---------${extraService.extra_services_original_price}</label>
                                                        <input type="number" class="form-control no-spinner" name="edit_panel_extra_service_prices[${service.sub_services_id}][${extraService.extra_services_id}]" value="${extraService.extra_service_price}" placeholder="Enter Price">
                                                     </div>`;
                                });
                            }
                        });
            
                        $("#edit_services_container").html(servicesHtml);
                    } catch (e) {
                        console.error("Parsing error:", e);
                        $("#edit_services_container").html("Error parsing response.");
                    }
                },
                error: function (response) {
                    $("#edit_services_container").html("Error: " + response);
                }
            });
            
        });
        // For update panel
        $("#edit_panel_form").on("submit", function (e) {
            e.preventDefault();
            if (!validate_panel_EditForm()) {
                return;
            }
            let formdata = $(this).serialize();
            $.ajax({
                url: "update_panel.php",
                type: "POST",
                data: formdata,
                success: function (response) {
                    console.log(response);
                    fetch_panel();
                    $("#editPanel").modal("hide");
                    alert_box("Panel Updated Successfully", "Panel Management");
                },
                error: function (res) {
                    alert("Error: " + res.responseText);
                }
            });
        });

        function validate_panel_EditForm() {
            var isValid = true;
            var subServicesSelected = {};
            var invalidSubServiceIds = [];
            var extraServicesErrors = [];

            // Check required fields
            $("#edit_panel_form input[required], #edit_panel_form select[required]").each(function () {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Collect selected sub-services
            $("#edit_panel_form input[type='checkbox'][name='edit_panel_services[]']").each(function () {
                if ($(this).is(':checked')) {
                    var subServiceId = $(this).val();
                    subServicesSelected[subServiceId] = true;
                }
            });

            // Collect selected extra services and validate against selected sub-services
            $("#edit_panel_form input[type='checkbox'][name^='edit_panel_extra_services']").each(function () {
                if ($(this).is(':checked')) {
                    var subServiceId = $(this).attr('name').match(/\d+/)[0];
                    if (!subServicesSelected[subServiceId]) {
                        if (!invalidSubServiceIds.includes(subServiceId)) {
                            invalidSubServiceIds.push(subServiceId);
                        }
                        extraServicesErrors.push($(this).val());
                    }
                }
            });

            // Mark sub-services as invalid if extra services are selected without them
            invalidSubServiceIds.forEach(function (subServiceId) {
                $("#edit_panel_form input[type='checkbox'][name='edit_panel_services[]'][value='" + subServiceId + "']").addClass('is-invalid');
            });

            // Show alert if there are any extra services selected without corresponding sub-services
            if (extraServicesErrors.length > 0) {
                isValid = false;
                alert('Please select the corresponding sub-services for the selected extra services.');
            }

            return isValid;
        }
        // for view panel
        $(document).on("click", ".view-panel", function () {
            $("#viewpanel").modal("show"); // Show the modal

            // Extract data attributes from the button
            let id = $(this).data("id");
            let company = $(this).data("company");
            let email = $(this).data("email");
            let manager = $(this).data("manager");
            let contact = $(this).data("contact");
            let manager_contact = $(this).data("manager_contact");
            let province_id = $(this).data("province_id");
            let city_id = $(this).data("city_id");
            let area_id = $(this).data("area_id");
            let status = $(this).data("status");
            let sub_services = $(this).data("sub_services");
            let services = $(this).data("services");
            let extra_services = $(this).data("extra_services");
            // Display panel information in modal
            $("#view_panel_id").text(id);
            $("#view_panel_company").text(company);
            $("#view_panel_email").text(email);
            $("#view_panel_manager").text(manager);
            $("#view_panel_company_contact").text(contact);
            $("#view_panel_contact").text(manager_contact);
            $("#view_panel_status").text(status);

            // Fetch and display Province
            $.ajax({
                url: "panel_fetch_province.php",
                type: "POST",
                data: { id: province_id },
                success: function (response) {
                    console.log(response);
                    $("#view_panel_province").text(response);
                },
                error: function (res) {
                    console.error("Error fetching province: " + res);
                }
            });

            // Fetch and display City
            $.ajax({
                url: "panel_fetch_city.php",
                type: "POST",
                data: { id: city_id },
                success: function (response) {
                    console.log(response);
                    $("#view_panel_city").text(response);
                },
                error: function (res) {
                    console.error("Error fetching city: " + res);
                }
            });

            // Fetch and display Area
            $.ajax({
                url: "panel_fetch_area.php",
                type: "POST",
                data: { id: area_id },
                success: function (response) {
                    console.log(response);
                    $("#view_panel_area").text(response);
                },
                error: function (res) {
                    console.error("Error fetching area: " + res);
                }
            });

            // continue on edit panel 

            // Display services information
            let servicesHtml = "<ul>";
            if (services.length > 0) {
                let displayedServices = new Set();

                services.forEach(service => {
                    if (!displayedServices.has(service.sub_service)) {
                        displayedServices.add(service.sub_service);

                        servicesHtml += `<li>${service.sub_service} (Price: ${service.sub_service_price})`;

                        // Check if there are extra services for this main service
                        let extrasForService = extra_services.filter(extra => extra.sub_services_id === service.sub_services_id);
                        if (extrasForService.length > 0) {
                            servicesHtml += "<ul>";
                            extrasForService.forEach(extra => {
                                servicesHtml += `<li>${extra.extra_service} (Price: ${extra.extra_service_price})</li>`;
                            });
                            servicesHtml += "</ul>";
                        }

                        servicesHtml += "</li>";
                    }
                });
            } else {
                servicesHtml += "<li>No services available.</li>";
            }
            servicesHtml += "</ul>";
            $("#view_panel_services").html(servicesHtml);

        });
        function fetch_panel() {
            $.ajax({
                url: "fetch_panel.php",
                type: "POST",
                success: function (response) {
                    console.log(response);
                    $("#panelTable").html(response);
                }
            })
        }

    }
    panel_management();

    // For Employee Page
    function employee_management() {
        // For insert employees and validation
        function formSubmitting() {
            // Function to update feedback message
            function updateFeedback(element, message) {
                var feedback = element.next('.invalid-feedback');
                if (message) {
                    feedback.text(message);
                    element.addClass('is-invalid');
                } else {
                    feedback.text('');
                    element.removeClass('is-invalid');
                }
            }

            // Auto-format Employee ID
            function formatEmpId(value) {
                value = value.replace(/\D/g, ''); // Remove non-numeric characters
                if (value.length > 4) {
                    value = value.slice(0, 4) + '-' + value.slice(4, 7);
                }
                return value;
            }

            // Form submission handling
            $("#insert_employee_form").on("submit", function (e) {
                e.preventDefault();

                var isValidForm = true;

                // Validate each field
                $('#insert_employee_form input, #insert_employee_form select').each(function () {
                    var element = $(this);
                    var id = element.attr('id');
                    var value = element.val().trim();

                    switch (id) {
                        case "emp_id":
                            var empIdPattern = /^\d{4}-\d{3}$/;
                            if (!empIdPattern.test(value)) {
                                updateFeedback(element, "Please enter the employee Id in the format 1234-567.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_name":
                            if (value === "") {
                                updateFeedback(element, "Employee name is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_father_name":
                            if (value === "") {
                                updateFeedback(element, "Father name is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_email":
                            if (value === "") {
                                updateFeedback(element, "Employee email is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_contact":
                            if (value === "") {
                                updateFeedback(element, "Contact Field Required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_nic":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please enter a valid NIC number with exactly 13 digits.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_dob":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please select a date of birth from previous years only.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_designation":
                            if (value === "") {
                                updateFeedback(element, "Please select a designation.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        // Add more cases for additional fields as needed
                    }
                });

                // If form is valid, submit via AJAX
                if (isValidForm) {
                    var formData = $(this).serialize();
                    $.ajax({
                        url: "insert_employee.php",
                        type: "POST",
                        data: formData,
                        success: function (response) {
                            console.log(response);
                            $("#add_employe").modal("hide");
                            alert_box('Employee Added Successfully', 'Referral Management');
                            $("#insert_employee_form")[0].reset();
                            fetch_employees();
                        },
                        error: function (xhr, status, error) {
                            alert('Error submitting form: ' + error);
                        }
                    });
                }
            });

            // Auto-format Employee ID on input
            $("#emp_id").on("input", function () {
                var element = $(this);
                var value = element.val();
                element.val(formatEmpId(value));
            });

            // Update feedback messages on input change
            $("#insert_employee_form input, #insert_employee_form select").on("change input", function () {
                var element = $(this);
                var id = element.attr("id");

                switch (id) {
                    case "emp_id":
                        var empIdPattern = /^\d{4}-\d{3}$/;
                        if (!empIdPattern.test(element.val().trim())) {
                            updateFeedback(element, "Please enter the employee Id in the format 1234-567.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_name":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Employee name is required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_father_name":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Father name is required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_email":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Employee email is required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_contact":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Contact Field Required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_nic":
                        if (!element[0].checkValidity()) {
                            updateFeedback(element, "Please enter a valid NIC number with exactly 13 digits.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_dob":
                        if (!element[0].checkValidity()) {
                            updateFeedback(element, "Please select a date of birth from previous years only.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_designation":
                        if (element.val() === "") {
                            updateFeedback(element, "Please select a designation.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                }
            });
        }
        formSubmitting();

        // For View Employees Details
        $(document).on("click", ".view-employee", function () {
            $("#viewEmployee").modal("show");
            var emp_id = $(this).data("emp_id");
            var name = $(this).data("name");
            var f_name = $(this).data("f_name");
            var email = $(this).data("email");
            var contact = $(this).data("contact");
            var nic = $(this).data("nic");
            var dob = $(this).data("dob");
            var designation = $(this).data("designation");
            if ($(this).data("designation") == "") {
                $("#emp_designation").html("No Designation Found.");
            } else {
                $("#emp_designation").html(designation);
            }
            var status = $(this).data("status");
            $("#emp_id").html(emp_id);
            $("#emp_name").html(name);
            $("#emp_f_name").html(f_name);
            $("#emp_email").html(email);
            $("#emp_contact").html(contact);
            $("#emp_nic").html(nic);
            $("#emp_dob").html(dob);
            $("#emp_status").html(status);
        })
        // For Fetch Reffral Details in Modal
        $(document).on("click", ".edit-employee", function () {
            $("#editEmployee").modal("show");
            var data = $(this).data();
            $("#tbl_id").val(data.id);
            $("#edit_emp_id").val(data.emp_id);
            $("#edit_emp_name").val(data.name);
            $("#edit_emp_father_name").val(data.f_name);
            $("#edit_emp_email").val(data.email);
            $("#edit_emp_contact").val(data.contact);
            $("#edit_emp_nic").val(data.nic);
            $("#edit_emp_dob").val(data.dob);
            $("#edit_emp_designation").val(data.designation).change();
        });
        function editFormSubmitting() {
            function updateFeedback(element, message) {
                if (message) {
                    element.addClass("is-invalid");
                    element.siblings(".invalid-feedback").text(message).show();
                } else {
                    element.removeClass("is-invalid");
                    element.siblings(".invalid-feedback").text("").hide();
                }
            }
            $("#edit_employee_form").on("submit", function (e) {
                e.preventDefault();
                var isValidForm = true;

                $('#edit_employee_form input, #edit_employee_form select').each(function () {
                    var element = $(this);
                    var id = element.attr('id');
                    var value = element.val().trim();

                    switch (id) {
                        case "edit_emp_name":
                            if (value === "") {
                                updateFeedback(element, "Employee name is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "edit_emp_father_name":
                            if (value === "") {
                                updateFeedback(element, "Father name is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "edit_emp_email":
                            if (value === "") {
                                updateFeedback(element, "Employee email is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "edit_emp_nic":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please enter a valid NIC number with exactly 13 digits.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "edit_emp_dob":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please select a date of birth from previous years only.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "edit_emp_designation":
                            if (value === "") {
                                updateFeedback(element, "Please select a designation.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                    }
                });

                if (isValidForm) {
                    var formData = $(this).serialize();
                    $.ajax({
                        url: "update_employee.php",
                        type: "POST",
                        data: formData,
                        success: function (response) {
                            console.log(response);
                            fetch_employees();
                            $("#editEmployee").modal("hide");
                            alert_box("Employee Updated Successfully", "Employee Management")
                            $("#edit_employee_form")[0].reset();
                        },
                        error: function (xhr, status, error) {
                            alert('Error submitting form: ' + error);
                        }
                    });
                }
            });
        }
        editFormSubmitting();
        // For Delete Reffral
        $(document).on('click', '.delete-employee', function () {
            const emp_id = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this Employee?');
            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_employee.php',
                    data: { id: emp_id },
                    success: function (response) {
                        console.log(response);
                        fetch_employees();
                        alert_box("Employee Deleted Successfully", "Employee Management")
                    },
                    error: function () {
                        alert('Failed to Delete Employee');
                    }
                });
            }
        });
        function fetch_employees() {
            $.ajax({
                url: "fetch_employee.php",
                type: "POST",
                success: function (response) {
                    console.log(response);
                    $("#employeeTable").html(response)
                }
            })
        }
        fetch_employees()
    }
    employee_management();

    // For User Page
    function user_management() {
        function addformSubmitting() {
            $('#insert_user_form').on("submit", function (e) {
                e.preventDefault();

                // Validate form fields
                if (validateForm()) {
                    // Serialize form data
                    var formData = $(this).serialize();

                    // Submit form via AJAX
                    $.ajax({
                        url: 'insert_user.php',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            console.log(response);
                            fetch_users();
                            alert_box("User Added Successfully", "User Management");
                            $("#add_user").modal("hide");
                            $('#insert_user_form')[0].reset();
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText); // Log error message
                            alert('An error occurred while adding the user. Please try again.');
                        }
                    });
                }
            });

            // Function to validate form fields
            function validateForm() {
                var isValid = true;

                // Reset all validation messages
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').hide();

                // Validate each field
                if ($('#emp_user_name').val().trim() === '') {
                    $('#emp_user_name').addClass('is-invalid');
                    $('#emp_user_name').siblings('.invalid-feedback').show();
                    isValid = false;
                }

                if ($('#emp_user_father_name').val().trim() === '') {
                    $('#emp_user_father_name').addClass('is-invalid');
                    $('#emp_user_father_name').siblings('.invalid-feedback').show();
                    isValid = false;
                }

                if ($('#emp_user_email').val().trim() === '') {
                    $('#emp_user_email').addClass('is-invalid');
                    $('#emp_user_email').siblings('.invalid-feedback').show();
                    isValid = false;
                }

                if ($('#emp_user_password').val().trim() === '') {
                    $('#emp_user_password').addClass('is-invalid');
                    $('#emp_user_password').siblings('.invalid-feedback').show();
                    isValid = false;
                }

                if (!/^\d{13}$/.test($('#emp_user_nic').val().trim())) {
                    $('#emp_user_nic').addClass('is-invalid');
                    $('#emp_user_nic').siblings('.invalid-feedback').show();
                    isValid = false;
                }

                if ($('#emp_user_dob').val().trim() === '' || !$('#emp_user_dob')[0].checkValidity()) {
                    $('#emp_user_dob').addClass('is-invalid');
                    $('#emp_user_dob').siblings('.invalid-feedback').show();
                    isValid = false;
                }

                return isValid;
            }
        }
        addformSubmitting();
        $(document).on("click", ".view-user", function () {
            $("#viewUser").modal("show");
            var id = $(this).data("id");
            var name = $(this).data("name");
            var f_name = $(this).data("f_name");
            var email = $(this).data("email");
            var password = $(this).data("password");
            var contact = $(this).data("contact");
            var nic = $(this).data("nic");
            var dob = $(this).data("dob");
            var pages = $(this).data("pages");
            var status = $(this).data("status");

            $("#emp_id").html(id);
            $("#emp_name").html(name);
            $("#emp_f_name").html(f_name);
            $("#emp_email").html(email);
            $("#emp_password").val(password);
            $("#emp_contact").html(contact);
            $("#emp_nic").html(nic);
            $("#emp_dob").html(dob);
            $("#emp_status").html(status);

            // Clear previous list of pages
            $("#emp_pages").empty();

            // Add each page to the list
            pages.forEach(function (page) {
                $("#emp_pages").append("<li>" + page + "</li>");
            });
        });
        // For Fetch Reffral Details in Modal
        $(document).on("click", ".edit-user", function () {
            $("#editUser").modal("show");
            var id = $(this).data("id");
            var name = $(this).data("name");
            var f_name = $(this).data("f_name");
            var email = $(this).data("email");
            var password = $(this).data("password");
            var contact = $(this).data("contact");
            var nic = $(this).data("nic");
            var dob = $(this).data("dob");
            var pages = $(this).data("pages");

            $("#edit_emp_user_id").val(id);
            $("#edit_emp_user_name").val(name);
            $("#edit_emp_user_father_name").val(f_name);
            $("#edit_emp_user_email").val(email);
            $("#edit_emp_user_password").val(password);
            $("#edit_emp_user_contact").val(contact);
            $("#edit_emp_user_nic").val(nic);
            $("#edit_emp_user_dob").val(dob);
            // Uncheck all checkboxes
            $(".form-check-input").prop("checked", false);

            // Check the checkboxes based on the user's pages
            pages.forEach(function (page) {
                $("input.form-check-input[value='" + page + "']").prop("checked", true);
            });
        });
        function editFormSubmitting() {
            $("#edit_user_form").on("submit", function (e) {
                e.preventDefault();

                var isValidForm = true;

                // Validate each field
                $('#edit_user_form input, #edit_user_form select').each(function () {
                    var element = $(this);
                    var id = element.attr('id');
                    var value = element.val().trim();

                    switch (id) {
                        case "edit_emp_user_name":
                        case "edit_emp_user_father_name":
                        case "edit_emp_user_email":
                            if (value === "") {
                                updateFeedback(element, "This field is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "edit_emp_user_nic":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please enter a valid NIC number with exactly 13 digits.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "edit_emp_user_dob":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please select a date of birth from previous years only.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        // Add more cases for additional fields as needed
                    }
                });
                // If form is valid, submit via AJAX
                if (isValidForm) {
                    var formData = $(this).serializeArray();

                    // Get all checked checkboxes
                    var checkedBoxes = $("input[name='edit_pages_access[]']:checked");

                    // If no checkboxes are selected, add a dummy value to indicate no changes
                    if (checkedBoxes.length === 0) {
                        formData.push({ name: "edit_pages_access[]", value: "no_change" });
                    }

                    $.ajax({
                        url: "update_user.php",
                        type: "POST",
                        data: $.param(formData),
                        success: function (response) {
                            console.log(response);
                            fetch_users();
                            $("#editUser").modal("hide");
                            alert_box("User Updated Successfully", 'User Management');
                            $("#edit_user_form")[0].reset();
                        },
                        error: function (xhr, status, error, res) {
                            alert('Error submitting form: ' + error + res);
                        }
                    });
                }

            });
            // Update feedback messages on input change
            $("#edit_user_form input, #edit_user_form select").on("change input", function () {
                var element = $(this);
                var id = element.attr("id");

                switch (id) {
                    case "edit_emp_user_name":
                        updateFeedback(element, element.val().trim() === "" ? "Employee name is required." : "");
                        break;
                    case "edit_emp_user_father_name":
                        updateFeedback(element, element.val().trim() === "" ? "Father name is required." : "");
                        break;
                    case "edit_emp_user_email":
                        updateFeedback(element, element.val().trim() === "" ? "Employee email is required." : "");
                        break;
                    case "edit_emp_user_nic":
                        updateFeedback(element, !element[0].checkValidity() ? "Please enter a valid NIC number with exactly 13 digits." : "");
                        break;
                    case "edit_emp_user_dob":
                        updateFeedback(element, !element[0].checkValidity() ? "Please select a date of birth from previous years only." : "");
                        break;
                    // Add more cases for additional fields as needed
                }
            });
            function updateFeedback(element, message) {
                if (message) {
                    element.addClass("is-invalid");
                    element.siblings(".invalid-feedback").text(message).show();
                } else {
                    element.removeClass("is-invalid");
                    element.siblings(".invalid-feedback").text("").hide();
                }
            }
        }
        editFormSubmitting();
        // For Delete Reffral
        $(document).on('click', '.delete-user', function () {
            const emp_id = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this User?');
            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_user.php',
                    data: { id: emp_id },
                    success: function (response) {
                        console.log(response);
                        fetch_users();
                        alert_box("User Deleted Successfully", "User Management");
                    },
                    error: function () {
                        alert('Failed to Delete User');
                    }
                });
            }
        });
        function fetch_users() {
            $.ajax({
                url: "fetch_user.php",
                type: "POST",
                success: function (response) {
                    console.log(response);
                    $("#userTable").html(response);
                }
            })
        }
        fetch_users()
    }
    user_management();

    function patient_management() {
        // For Fetch Province in insert  Panel Modal
        $("#patient_province").on("change", function () {
            let province = $(this).val();
            $.ajax({
                url: "patient_fetch_city_option.php",
                type: "POST",
                data: { id: province },
                success: function (response) {
                    console.log(response);
                    $("#patient_city").html(response);
                    let city = $("#patient_city").val();
                    $.ajax({
                        url: "patient_fetch_area_option.php",
                        type: "POST",
                        data: { id: city },
                        success: function (response) {
                            console.log(response);
                            $("#patient_area").html(response);
                        }
                    });
                }
            });
        });
        // For Fetch City in insert  Panel Modal 
        $("#patient_city").on("change", function () {
            let city = $(this).val();
            $.ajax({
                url: "patient_fetch_area_option.php",
                type: "POST",
                data: { id: city },
                success: function (response) {
                    console.log(response);
                    $("#patient_area").html(response);
                    // Automatically select the first area in the list
                    let firstAreaOption = $("#patient_area option:first").val();
                    $("#patient_area").val(firstAreaOption).change(); // Trigger change event if needed
                }
            });
        });
        // For Fetch Province in Edit  Panel Modal 
        $("#edit_patient_province").on("change", function () {
            let province = $(this).val();
            $.ajax({
                url: "patient_fetch_edit_city_option.php",
                type: "POST",
                data: { id: province },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_city").html(response);
                    let city = $("#edit_patient_city").val();
                    $.ajax({
                        url: "patient_fetch_edit_area_option.php",
                        type: "POST",
                        data: { id: city },
                        success: function (response) {
                            console.log(response);
                            $("#edit_patient_area").html(response);
                        }
                    });
                }
            });
        });
        // For Fetch City in Edit  Panel Modal 
        $("#edit_patient_city").on("change", function () {
            let city = $(this).val();
            $.ajax({
                url: "patient_fetch_edit_area_option.php",
                type: "POST",
                data: { id: city },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_area").html(response);

                    // Automatically select the first area in the list
                    let firstAreaOption = $("#edit_patient_area option:first").val();
                    $("#edit_patient_area").val(firstAreaOption).change(); // Trigger change event if needed
                }
            });
        });
        function insertPatientForm() {
            // Update minimum discharge date based on admit date
            $('#patient_admit_date').on('change', function () {
                var admitDate = $(this).val();
                $('#patient_discharge_date').attr('min', admitDate);
            });
            // Form submission with validation
            $('#insert_patient_form').on('submit', function (e) {
                e.preventDefault();
                var admitDate = new Date($('#patient_admit_date').val());
                var dischargeDate = new Date($('#patient_discharge_date').val());
                var isValid = true;
                var errorMessage = '';

                if (dischargeDate < admitDate) {
                    isValid = false;
                    errorMessage += 'Discharge date cannot be earlier than admit date.\n';
                }

                if (!isValid) {
                    alert(errorMessage);
                    return; // Exit the function if the form is invalid
                }

                // Serialize the form data
                var formData = $(this).serialize();

                // Send the data using AJAX
                $.ajax({
                    url: 'insert_patient.php', // Server script to process data
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        $('#add_patient').modal('hide');
                        fetch_patients();
                        alert_box('Patient Inserted Successfully', 'Patient Management');
                        $('#insert_patient_form').trigger('reset');
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        alert('An error occurred: ' + error);
                    }
                });
            });

        }
        insertPatientForm();
        $(document).on("click", ".view-patient", function () {
            // Show modal
            $('#viewPatient').modal('show');
            var registration_date = $(this).data('registration_date');
            var mr_no = $(this).data('mr_no');
            var change_person = $(this).data('changes_person');
            var name = $(this).data('name');
            var attendent_name = $(this).data('attendent_name');
            var email = $(this).data('email');
            var contact = $(this).data('contact');
            var whatsapp = $(this).data('whatsapp');
            var patient_status = $(this).data('patient_status');
            var age = $(this).data('age');
            var gender = $(this).data('gender');
            var ad_date = $(this).data('ad_date');
            var dis_date = $(this).data('dis_date');
            var total_days = $(this).data('total_days');
            var province_id = $(this).data('province_id');
            var city_id = $(this).data('city_id');
            var area_id = $(this).data('area_id');
            var refferal_id = $(this).data('refferal_id');
            var panel_id = $(this).data('panel_id');
            var employee_id = $(this).data('employee_id');
            var p_status = $(this).data('p_status');
            var patient_rate = $(this).data('patient_rate');
            var staff_rate = $(this).data('staff_rate');
            var service_id = $(this).data('service_id');
            var recovery = $(this).data('recovery');
            var running_bill = $(this).data('running_bill');

            // Populate modal fields
            $('#view_patient_registration_date').text(registration_date);
            $('#view_patient_mr_no').text(mr_no);
            $('#view_patient_name').text(name);
            $('#view_patient_email').text(email);
            $('#view_patient_attendent_name').text(attendent_name);
            $('#view_patient_contact').text(contact);
            $('#view_patient_whatsapp').text(whatsapp);
            $('#view_patient_age').text(age);
            $('#view_patient_gender').text(gender);
            $('#view_patient_ad_date').text(ad_date);
            $('#view_patient_dis_date').text(dis_date);
            $('#view_patient_total_days').text(total_days);
            $('#view_patient_status').text(patient_status);
            // For fetch Province
            $.ajax({
                url: "patient_fetch_province.php",
                type: "POST",
                data: { id: province_id },
                success: function (response) {
                    console.log(response);
                    $("#view_patient_province").text(response);
                }
            });
            // For fetch City
            $.ajax({
                url: "patient_fetch_city.php",
                type: "POST",
                data: { id: city_id },
                success: function (response) {
                    console.log(response);
                    $("#view_patient_city").text(response);
                }
            });
            // For fetch Area
            $.ajax({
                url: "patient_fetch_area.php",
                type: "POST",
                data: { id: area_id },
                success: function (response) {
                    console.log(response);
                    $("#view_patient_area").text(response);
                }
            });
            // For fetch Refferal
            $.ajax({
                url: "patient_fetch_refferal.php",
                type: "POST",
                data: { id: refferal_id },
                success: function (response) {
                    console.log(response);
                    $("#view_patient_refferal_id").text(response);
                }
            });
            // For fetch Panel
            $.ajax({
                url: "patient_fetch_panel.php",
                type: "POST",
                data: { id: panel_id },
                success: function (response) {
                    console.log(response);
                    $("#view_patient_panel_id").text(response);
                }
            });
            // For fetch Employee
            $.ajax({
                url: "patient_fetch_employee.php",
                type: "POST",
                data: { id: employee_id },
                success: function (response) {
                    console.log(response);
                    $("#view_patient_employee_id").text(response);
                }
            });
            // For fetch Services
            $.ajax({
                url: "patient_fetch_service.php",
                type: "POST",
                data: { id: service_id },
                success: function (response) {
                    console.log(response);
                    $("#view_patient_service_id").text(response);
                }
            });
            $('#view_patient_payment_status').text(p_status);
            $('#view_patient_patient_rate').text(patient_rate);
            $('#view_patient_staff_rate').text(staff_rate);
            $('#view_patient_recovery').text(recovery);
            $('#view_patient_running_bill').text(running_bill);
            $('#view_patient_changes_person').text(change_person);
        });
        $(document).on("click", ".edit-patient", function () {
            // Show the modal
            $('#edit_patient').modal('show');

            // Get data attributes
            var data = $(this).data();

            // Populate form fields with data
            $('#edit_patient_id').val(data.id);
            $('#edit_patient_name').val(data.name);
            $('#edit_attendent_name').val(data.attendent_name);
            $('#edit_patient_email').val(data.email);
            $('#edit_patient_contact').val(data.contact);
            $('#edit_patient_whatsapp').val(data.whatsapp);
            $('#edit_patient_address').val(data.address);
            $('#edit_edit_patient_address').val(data.address);
            $('#edit_patient_age').val(data.age);
            $('#edit_patient_gender').val(data.gender);
            $('#edit_patient_admit_date').val(data.ad_date);
            let gettingDate = $('#edit_patient_admit_date').val();
            $('#edit_patient_discharge_date').val(data.dis_date);
            $('#edit_patient_status').val(data.patient_status);
            $('#edit_payment_status').val(data.p_status);
            $('#edit_patient_rate').val(data.patient_rate);
            $('#edit_staff_rate').val(data.staff_rate);
            $('#edit_recovery').val(data.recovery);
            $('#edit_running_bill').val(data.running_bill);
            $('#edit_note').val(data.note);
            // For fetch Province
            $.ajax({
                url: "patient_edit_fetch_province.php",
                type: "POST",
                data: { id: data.province_id },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_province").html(response);
                }
            });
            // For fetch City
            $.ajax({
                url: "patient_edit_fetch_city.php",
                type: "POST",
                data: {
                    id: data.city_id,
                    p_id: data.province_id
                },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_city").html(response);
                }
            });
            // For fetch Area
            $.ajax({
                url: "patient_edit_fetch_area.php",
                type: "POST",
                data: {
                    id: data.area_id,
                    c_id: data.city_id
                },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_area").html(response);
                }
            });
            // For fetch Refferal
            $.ajax({
                url: "patient_edit_fetch_refferal.php",
                type: "POST",
                data: { id: data.refferal_id },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_refferal").html(response);
                }
            });
            // For fetch Panel
            $.ajax({
                url: "patient_edit_fetch_panel.php",
                type: "POST",
                data: { id: data.panel_id },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_panel").html(response);
                }
            });
            // For fetch Employee
            $.ajax({
                url: "patient_edit_fetch_employee.php",
                type: "POST",
                data: { id: data.employee_id },
                success: function (response) {
                    console.log(response);
                    $("#edit_employee_staff").html(response);
                }
            });
            // For fetch Services
            $.ajax({
                url: "patient_edit_fetch_service.php",
                type: "POST",
                data: { id: data.service_id },
                success: function (response) {
                    console.log(response);
                    $("#edit_patient_service").html(response);
                }
            });
            setupPatientEditForm(gettingDate);
        });
        function setupPatientEditForm(getDate) {

            $('#edit_patient_discharge_date').attr('min', getDate);
            $('#edit_patient_admit_date').on('change', function () {
                var admitDate = $(this).val();
                $('#edit_patient_discharge_date').attr('min', admitDate);
            });

            // Form submission with validation
            $('#edit_patient_form').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                var admitDate = new Date($('#edit_patient_admit_date').val());
                var dischargeDate = new Date($('#edit_patient_discharge_date').val());
                var isValid = true;
                var errorMessage = '';

                // Validate that discharge date is not before admit date
                if (dischargeDate < admitDate) {
                    isValid = false;
                    errorMessage += 'Discharge date cannot be earlier than admit date.\n';
                }

                if (!isValid) {
                    alert(errorMessage);
                    return; // Exit the function if the form is invalid
                }
                // alert($("#edit_changes_person").val());
                // Serialize the form data
                var formData = $(this).serialize();

                // Send the data using AJAX
                $.ajax({
                    url: 'update_patients.php', // Server script to process data
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        $('#edit_patient').modal('hide');
                        fetch_patients();
                        alert_box('Patient data updated successfully!', 'Patient Management');
                        $('#edit_patient_form').trigger('reset');
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        alert('An error occurred: ' + error);
                    }
                });
            });
        }
        function fetch_patients() {
            $.ajax({
                url: "fetch_patients.php",
                type: "POST",
                success: function (response) {
                    console.log(response);
                    $("#patientTable").html(response)
                }
            })
        }
        fetch_patients();
    }
    patient_management();

    function vendor_management() {
        fetch_vendor();
        // For Fetch Province in insert  Panel Modal
        $("#vendor_province").on("change", function () {
            let province = $(this).val();
            $.ajax({
                url: "vendor_fetch_city_option.php",
                type: "POST",
                data: { id: province },
                success: function (response) {
                    console.log(response);
                    $("#vendor_city").html(response);
                    let city = $("#vendor_city").val();
                    $.ajax({
                        url: "vendor_fetch_area_option.php",
                        type: "POST",
                        data: { id: city },
                        success: function (response) {
                            console.log(response);
                            $("#vendor_area").html(response);
                        }
                    });
                }
            });
        });
        // For Fetch City in insert  Panel Modal 
        $("#vendor_city").on("change", function () {
            let city = $(this).val();
            $.ajax({
                url: "vendor_fetch_area_option.php",
                type: "POST",
                data: { id: city },
                success: function (response) {
                    console.log(response);
                    $("#vendor_area").html(response);

                    // Automatically select the first area in the list
                    let firstAreaOption = $("#vendor_area option:first").val();
                    $("#vendor_area").val(firstAreaOption).change(); // Trigger change event if needed
                }
            });
        });
        // for insert Data
        $("#vendor_form").on("submit", function (e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            var formData = $(this).serialize();
            $.ajax({
                url: "insert_vendor.php",
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log(response);
                    if (response === "Vendor Inserted Successfully") {
                        $("#vendor_modal").modal("hide");
                        fetch_vendor();
                        alert_box("Vendor Inserted Successfully", "Vendor Management");
                        $("#vendor_form")[0].reset();
                    } else {
                        alert("Unexpected response: " + response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
        // for view vendor 
        $(document).on("click", ".view-vendor", function () {
            $("#viewVendor").modal("show");

            // Extract data attributes from the button
            let id = $(this).data("vendor_id");
            let name = $(this).data("vendor_name");
            let ntn = $(this).data("vendor_ntn");
            let contact = $(this).data("vendor_contact");
            let w_contact = $(this).data("vendor_w_contact");
            let address = $(this).data("vendor_address");
            let focal_person = $(this).data("focal_person");
            let province_id = $(this).data("province_id");
            let city_id = $(this).data("city_id");
            let area_id = $(this).data("area_id");
            let status = $(this).data("vendor_status");
            let services = $(this).data("services");
            let extra_services = $(this).data("extra_services");
            // Display vendor information in modal
            $("#view_vendor_id").text(id);
            $("#view_vendor_name").text(name);
            $("#view_vendor_ntn").text(ntn);
            $("#view_vendor_contact").text(contact);
            $("#view_vendor_w_contact").text(w_contact);
            $("#view_vendor_address").text(address);
            $("#view_vendor_f_person").text(focal_person);
            $("#view_vendor_status").text(status);

            // Fetch and display Province
            $.ajax({
                url: "vendor_fetch_province.php",
                type: "POST",
                data: { id: province_id },
                success: function (response) {
                    $("#view_vendor_province").text(response);
                },
                error: function (res) {
                    console.error("Error fetching province: " + res);
                }
            });

            // Fetch and display City
            $.ajax({
                url: "vendor_fetch_city.php",
                type: "POST",
                data: { id: city_id },
                success: function (response) {
                    $("#view_vendor_city").text(response);
                },
                error: function (res) {
                    console.error("Error fetching city: " + res);
                }
            });

            // Fetch and display Area
            $.ajax({
                url: "vendor_fetch_area.php",
                type: "POST",
                data: { id: area_id },
                success: function (response) {
                    $("#view_vendor_area").text(response);
                },
                error: function (res) {
                    console.error("Error fetching area: " + res);
                }
            });

            // Combine and display services and extra services information
            let combinedServicesHtml = "<ul>";
            if (services && Object.keys(services).length > 0) {
                Object.keys(services).forEach(serviceId => {
                    let service = services[serviceId];
                    // Only proceed if service is valid and not null
                    if (service && service.sub_service) {
                        combinedServicesHtml += `<li>${service.sub_service} (Price: ${service.sub_service_price})`;

                        // Check and display extra services associated with this service
                        if (service.extra_services && service.extra_services.length > 0) {
                            combinedServicesHtml += "<ul>";
                            service.extra_services.forEach(extra => {
                                if (extra && extra.extra_service) { // Ensure extra service is valid
                                    combinedServicesHtml += `<li>${extra.extra_service} (Price: ${extra.extra_service_price})</li>`;
                                }
                            });
                            combinedServicesHtml += "</ul>";
                        }

                        combinedServicesHtml += "</li>";
                    }
                });
            } else {
                combinedServicesHtml += "<li>No services available</li>";
            }

            // Include extra services that are not already included
            if (extra_services && extra_services.length > 0) {
                extra_services.forEach(extra => {
                    // Add only if this extra service is not already included
                    let alreadyAdded = Object.values(services).some(service =>
                        service.extra_services && service.extra_services.some(e => e.extra_service === extra.extra_service)
                    );

                    if (!alreadyAdded && extra && extra.extra_service) {
                        combinedServicesHtml += `<li>${extra.extra_service} (Price: ${extra.extra_service_price})</li>`;
                    }
                });
            }

            combinedServicesHtml += "</ul>";
            $("#view_vendor_services").html(combinedServicesHtml);
        });
        function validateForm() {
            var isValid = true;
            var subServicesSelected = {};

            $("#vendor_form input[required], #vendor_form select[required]").each(function () {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            $("#vendor_form input[type='checkbox'][name^='extra_services']").each(function () {
                var subServiceId = $(this).attr('name').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    subServicesSelected[subServiceId] = subServicesSelected[subServiceId] || false;
                }
            });

            for (var subServiceId in subServicesSelected) {
                if (subServicesSelected.hasOwnProperty(subServiceId)) {
                    var subServiceCheckbox = $("#vendor_form input[type='checkbox'][name='services[]'][value='" + subServiceId + "']");
                    if (!subServiceCheckbox.is(':checked')) {
                        isValid = false;
                        subServiceCheckbox.addClass('is-invalid');
                    } else {
                        subServiceCheckbox.removeClass('is-invalid');
                    }
                }
            }

            return isValid;
        }
        $(document).on("click", ".edit-vendor", function () {
            $("#editVendor").modal("show");
            // Extract data attributes from the button  
            let id = $(this).data("vendor_id");
            let name = $(this).data("vendor_name");
            let ntn = $(this).data("vendor_ntn");
            let contact = $(this).data("vendor_contact");
            let w_contact = $(this).data("vendor_w_contact");
            let address = $(this).data("vendor_address");
            let focal_person = $(this).data("focal_person");
            let status = $(this).data("vendor_status");

            // Display vendor information in modal
            $("#edit_vendor_id").val(id);
            $("#edit_vendor_name").val(name);
            $("#edit_vendor_ntn").val(ntn);
            $("#edit_vendor_contact").val(contact);
            $("#edit_vendor_w_contact").val(w_contact);
            $("#edit_vendor_address").val(address);
            $("#edit_focal_person").val(focal_person);
            $("#edit_vendor_status").val(status);

            // Fetch Province, City, Area
            $.ajax({
                url: "vendor_fetch_province_option.php",
                type: "POST",
                data: { id: $(this).data('province_id') },
                success: function (response) {
                    $("#edit_vendor_province").html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Province Fetch Error:", xhr, status, error);
                    $("#edit_vendor_province").html("Error: " + xhr.responseText);
                }
            });
            $.ajax({
                url: "vendor_fetch_city_sec_option.php",
                type: "POST",
                data: {
                    id: $(this).data('city_id'),
                    p_id: $(this).data('province_id')
                },
                success: function (response) {
                    $("#edit_vendor_city").html(response);
                },
                error: function (xhr, status, error) {
                    console.error("City Fetch Error:", xhr, status, error);
                    $("#edit_vendor_city").html("Error: " + xhr.responseText);
                }
            });
            $.ajax({
                url: "vendor_fetch_area_sec_option.php",
                type: "POST",
                data: {
                    id: $(this).data('area_id'),
                    c_id: $(this).data('city_id')
                },
                success: function (response) {
                    $("#edit_vendor_area").html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Area Fetch Error:", xhr, status, error);
                    $("#edit_vendor_area").html("Error: " + xhr.responseText);
                }
            });
            $.ajax({
                url: "vendor_fetch_services.php", // Replace with the path to your PHP file
                type: "POST",
                data: { vendor_id: id }, // Make sure 'id' is defined elsewhere in your code
                success: function (response) {
                    // Check if the response is an HTML string
                    if (typeof response === "string") {
                        $("#edit_services_container").html(response);
                    } else {
                        console.error("Unexpected response format: ", response);
                        $("#edit_services_container").html("Error: Unexpected response format.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching services:", status, error);
                    $("#edit_services_container").html("Error: " + status + " " + error);
                }
            });

        });
        // For update panel
        $("#edit_vendor_form").on("submit", function (e) {
            e.preventDefault();

            if (!validateEditForm()) {
                return;
            }

            let formdata = $(this).serialize();

            $.ajax({
                url: "update_vendor.php", // Update URL to match your PHP script
                type: "POST",
                data: formdata,
                success: function (response) {
                    console.log(response);
                    $("#editVendor").modal("hide");
                    fetch_vendor(); // Ensure this function updates your vendor list
                    alert_box("Vendor Updated Successfully", "Vendor Management"); // Custom function for showing alerts
                },
                error: function (xhr) {
                    alert("Error: " + xhr.responseText);
                }
            });
        });
        function validateEditForm() {
            var isValid = true;
            var subServicesSelected = {};
            var invalidSubServiceIds = [];
            var extraServicesErrors = [];

            // Check required fields
            $("#edit_vendor_form input[required], #edit_vendor_form select[required]").each(function () {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Collect selected sub-services
            $("#edit_vendor_form input[type='checkbox'][name='edit_vendor_services[]']").each(function () {
                if ($(this).is(':checked')) {
                    var subServiceId = $(this).val();
                    subServicesSelected[subServiceId] = true;
                }
            });

            // Collect selected extra services and validate against selected sub-services
            $("#edit_vendor_form input[type='checkbox'][name^='edit_vendor_extra_services']").each(function () {
                if ($(this).is(':checked')) {
                    var subServiceId = $(this).attr('name').match(/\d+/)[0];
                    var extraServiceId = $(this).val();

                    if (!subServicesSelected[subServiceId]) {
                        if (!invalidSubServiceIds.includes(subServiceId)) {
                            invalidSubServiceIds.push(subServiceId);
                        }
                        extraServicesErrors.push(extraServiceId);
                    }
                }
            });

            // Mark sub-services as invalid if extra services are selected without them
            invalidSubServiceIds.forEach(function (subServiceId) {
                $("#edit_vendor_form input[type='checkbox'][name='edit_vendor_services[]'][value='" + subServiceId + "']").addClass('is-invalid');
            });

            // Show alert if there are any extra services selected without corresponding sub-services
            if (extraServicesErrors.length > 0) {
                isValid = false;
                alert('Please select the corresponding sub-services for the selected extra services.');
            }

            return isValid;
        }
        function fetch_vendor() {
            $.ajax({
                url: "fetch_vendor.php",
                type: "POST",
                success: function (response) {
                    console.log(response);
                    $("#vendorTable").html(response);
                }
            })
        }
    }
    vendor_management();

    function transaction_management(){
        // For Fetch Sub Service in insert transaction Modal 
        $("#service").on("change", function () {
            let service = $(this).val();
            $.ajax({
                url: "transaction_fetch_service_option.php",
                type: "POST",
                data: { id: service },
                success: function (response) {
                    console.log(response);
                    $("#sub_service").html(response);
                    let sub_service = $("#sub_service").val();
                    $.ajax({
                        url: "transaction_fetch_sub_service_option.php",
                        type: "POST",
                        data: { id: sub_service },
                        success: function (response) {
                            console.log(response);
                            $("#extra_service").html(response);
                        }
                    });
                }
            });
        });
        // For Fetch Extra Service in insert transaction Modal 
        $("#sub_service").on("change", function () {
            let sub_service = $(this).val();
            $.ajax({
                url: "transaction_fetch_sub_service_option.php",
                type: "POST",
                data: { id: sub_service },
                success: function (response) {
                    console.log(response);
                    $("#extra_service").html(response);

                    // Automatically select the first area in the list
                    let firstsubServiceOption = $("#extra_service option:first").val();
                    $("#extra_service").val(firstsubServiceOption).change(); // Trigger change event if needed
                }
            });
        });
        
    }
    transaction_management();
    // For Alert Message
    function alert_box(message, heading) {
        toastr.options.progressBar = true;
        toastr.options.timeOut = 3000;
        toastr.success(message, heading);
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 300;
        toastr.options.closeEasing = 'swing';
    }
})