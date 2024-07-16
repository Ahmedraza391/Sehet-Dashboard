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
                    success: function (res) {
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
                url: "add_refferals.php",
                type: "POST",
                data: formData,
                success: function (res) {
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
                success: function (res) {
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
                success: function (res) {
                    $("#reffralTable").html(res)
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
                success: function (res) {
                    $("#city_id").html(res);
                    let city = $("#city_id").val();
                    $.ajax({
                        url: "panel_fetch_area_option.php",
                        type: "POST",
                        data: { id: city },
                        success: function (res) {
                            $("#area_id").html(res);
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
                success: function (res) {
                    $("#area_id").html(res);

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
                success: function (res) {
                    $("#edit_city_id").html(res);
                    let city = $("#edit_city_id").val();
                    $.ajax({
                        url: "panel_fetch_edit_area_option.php",
                        type: "POST",
                        data: { id: city },
                        success: function (res) {
                            $("#edit_area_id").html(res);
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
                success: function (res) {
                    $("#edit_area_id").html(res);

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

            $("#panel_form input[required], #panel_form select[required]").each(function () {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            $("#panel_form input[type='checkbox'][name^='extra_services']").each(function () {
                var subServiceId = $(this).attr('name').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    subServicesSelected[subServiceId] = subServicesSelected[subServiceId] || false;
                }
            });

            for (var subServiceId in subServicesSelected) {
                if (subServicesSelected.hasOwnProperty(subServiceId)) {
                    var subServiceCheckbox = $("#panel_form input[type='checkbox'][name='services[]'][value='" + subServiceId + "']");
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
        function validateEditForm() {
            var isValid = true;
            var subServicesSelected = {};

            $("#edit_panel_form input[required], #edit_panel_form select[required]").each(function () {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            $("#edit_panel_form input[type='checkbox'][name^='extra_services']").each(function () {
                var subServiceId = $(this).attr('name').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    subServicesSelected[subServiceId] = subServicesSelected[subServiceId] || false;
                }
            });

            for (var subServiceId in subServicesSelected) {
                if (subServicesSelected.hasOwnProperty(subServiceId)) {
                    var subServiceCheckbox = $("#edit_panel_form input[type='checkbox'][name='edit_services[]'][value='" + subServiceId + "']");
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
                success: function (res) {
                    if (res === "Panel Inserted Successfully") {
                        $("#panel_modal").modal("hide");
                        fetch_panel();
                        alert_box("Panel Inserted Successfully", "Panel Management");
                        $("#panel_form")[0].reset();
                    } else {
                        alert("Unexpected response: " + res);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
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
                success: function (res) {
                    $("#edit_province").html(res);
                },
                error: function (res) {
                    $("#edit_province").html("Error: " + res);
                }
            });
            $.ajax({
                url: "panel_fetch_city_sec_option.php",
                type: "POST",
                data: { id: $(this).data('city_id') },
                success: function (res) {
                    $("#edit_city_id").html(res);
                },
                error: function (res) {
                    $("#edit_city_id").html("Error: " + res);
                }
            });
            $.ajax({
                url: "panel_fetch_area_sec_option.php",
                type: "POST",
                data: { id: $(this).data('area_id') },
                success: function (res) {
                    $("#edit_area_id").html(res);
                },
                error: function (res) {
                    $("#edit_area_id").html("Error: " + res);
                }
            });

            // Fetch and display services and extra services with prices
            $.ajax({
                url: "panel_fetch_services.php",
                type: "POST",
                data: { panel_id: panel_id },
                success: function (response) {
                    let services = JSON.parse(response);
                    let servicesHtml = '';

                    services.forEach(service => {
                        servicesHtml += `<div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="edit_panel_services[]" value="${service.sub_services_id}" id="service_${service.sub_services_id}" ${service.selected ? 'checked' : ''}>
                                            <label class="form-check-label" for="service_${service.sub_services_id}">${service.sub_service}</label>
                                            <input type="number" class="form-control" name="edit_panel_service_prices[${service.sub_services_id}]" value="${service.sub_service_price}" placeholder="Enter Price">
                                         </div>`;

                        if (Object.keys(service.extra_services).length > 0) {
                            Object.values(service.extra_services).forEach(extraService => {
                                servicesHtml += `<div class="form-check ms-md-5">
                                                    <input class="form-check-input" type="checkbox" name="edit_panel_extra_services[${service.sub_services_id}][]" value="${extraService.extra_services_id}" id="extra_service_${extraService.extra_services_id}" ${extraService.selected ? 'checked' : ''}>
                                                    <label class="form-check-label" for="extra_service_${extraService.extra_services_id}">${extraService.extra_service}</label>
                                                    <input type="number" class="form-control" name="edit_panel_extra_service_prices[${service.sub_services_id}][${extraService.extra_services_id}]" value="${extraService.extra_service_price}" placeholder="Enter Price">
                                                 </div>`;
                            });
                        }
                    });

                    $("#edit_services_container").html(servicesHtml);
                },
                error: function (response) {
                    $("#edit_services_container").html("Error: " + response);
                }
            });
        });


        $("#edit_panel_form").on("submit", function (e) {
            e.preventDefault();
            if (!validateEditForm()) {
                return;
            }
            let formdata = $(this).serialize();
            $.ajax({
                url: "update_panel.php",
                type: "POST",
                data: formdata,
                success: function (res) {
                    fetch_panel();
                    $("#editPanel").modal("hide");
                    alert_box("Panel Updated Successfully", "Panel Management");
                },
                error: function (res) {
                    alert("Error: " + res);
                }
            });
        });

        // For Delete Panel
        $(document).on("click", ".delete-panel", function () {
            let del_id = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this Panel?');
            if (confirmation) {
                $.ajax({
                    url: "delete_panel.php",
                    type: "POST",
                    data: { id: del_id },
                    success: function (res) {
                        fetch_panel();
                    },
                    error: function (xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            }
        });
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
                success: function (res) {
                    $("#view_panel_province").text(res);
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
                success: function (res) {
                    $("#view_panel_city").text(res);
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
                success: function (res) {
                    $("#view_panel_area").text(res);
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
                success: function (res) {
                    $("#panelTable").html(res);
                }
            })
        }

    }
    panel_management();

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
                        case "emp_emai":
                            if (value === "") {
                                updateFeedback(element, "Employee email is required.");
                                isValidForm = false;
                            } else {
                                updateFeedback(element, "");
                            }
                            break;
                        case "emp_contact":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please enter a valid contact number starting with 03 and having 11 digits.");
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
                        url: "employee_insert_registration.php",
                        type: "POST",
                        data: formData,
                        success: function (res) {
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

            // Update feedback messages on input change
            $("#insert_employee_form input, #insert_employee_form select").on("change input", function () {
                var element = $(this);
                var id = element.attr("id");

                switch (id) {
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
                    case "emp_emai":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Employee email is required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "emp_contact":
                        if (!element[0].checkValidity()) {
                            updateFeedback(element, "Please enter a valid contact number starting with 03 and having 11 digits.");
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
            var id = $(this).data("id");
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
            $("#emp_id").html(id);
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
            var id = $(this).data("id");
            var name = $(this).data("name");
            var f_name = $(this).data("f_name");
            var email = $(this).data("email");
            var contact = $(this).data("contact");
            var nic = $(this).data("nic");
            var dob = $(this).data("dob");
            var designation = $(this).data("designation");
            $("#edit_emp_id").val(id);
            $("#edit_emp_name").val(name);
            $("#edit_emp_father_name").val(f_name);
            $("#edit_emp_email").val(email);
            $("#edit_emp_contact").val(contact);
            $("#edit_emp_nic").val(nic);
            $("#edit_emp_dob").val(dob);
            // Set the selected designation
            $("#edit_emp_designation").val(designation).change();
        });
        function editFormSubmitting() {
            // Form submission handling for edit_employee_form
            $("#edit_employee_form").on("submit", function (e) {
                e.preventDefault();

                var isValidForm = true;

                // Validate each field
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
                        case "edit_emp_contact":
                            if (!element[0].checkValidity()) {
                                updateFeedback(element, "Please enter a valid contact number starting with 03 and having 11 digits.");
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
                        // Add more cases for additional fields as needed
                    }
                });

                // If form is valid, submit via AJAX
                if (isValidForm) {
                    var formData = $(this).serialize();
                    $.ajax({
                        url: "update_employee.php",
                        type: "POST",
                        data: formData,
                        success: function (res) {
                            $("#editEmployee").modal("hide");
                            alert_box(res, 'Employees Management');
                            $("#edit_employee_form")[0].reset();
                            fetch_employees();
                        },
                        error: function (xhr, status, error) {
                            alert('Error submitting form: ' + error);
                        }
                    });
                }
            });

            // Update feedback messages on input change
            $("#edit_employee_form input, #edit_employee_form select").on("change input", function () {
                var element = $(this);
                var id = element.attr("id");

                switch (id) {
                    case "edit_emp_name":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Employee name is required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "edit_emp_father_name":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Father name is required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "edit_emp_email":
                        if (element.val().trim() === "") {
                            updateFeedback(element, "Employee email is required.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "edit_emp_contact":
                        if (!element[0].checkValidity()) {
                            updateFeedback(element, "Please enter a valid contact number starting with 03 and having 11 digits.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "edit_emp_nic":
                        if (!element[0].checkValidity()) {
                            updateFeedback(element, "Please enter a valid NIC number with exactly 13 digits.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "edit_emp_dob":
                        if (!element[0].checkValidity()) {
                            updateFeedback(element, "Please select a date of birth from previous years only.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
                    case "edit_emp_designation":
                        if (element.val() === "") {
                            updateFeedback(element, "Please select a designation.");
                        } else {
                            updateFeedback(element, "");
                        }
                        break;
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
        $(document).on('click', '.delete-employee', function () {
            const emp_id = $(this).data('id');
            const confirmation = confirm('Are you sure you want to delete this Employee?');
            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_employee.php',
                    data: { id: emp_id },
                    success: function (response) {
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
                success: function (res) {
                    $("#employeeTable").html(res)
                }
            })
        }
        fetch_employees()
    }
    employee_management();
    function alert_box(message, heading) {
        toastr.options.progressBar = true;
        toastr.options.timeOut = 3000;
        toastr.success(message, heading)
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 300;
        toastr.options.closeEasing = 'swing';
    }
})