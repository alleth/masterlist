$(function () {

    const maxChars = 60;
    $('#leaveReason').on('input', function () {
        const remaining = maxChars - $(this).val().length;
        $('#reasonCharCount').text(remaining);
    });

    const $carousel = $('#carouselSlides');
    const $dots = $('.progress-dot');
    const $lineFill = $('.progress-line-fill');

    let carousel = new bootstrap.Carousel($carousel[0], {
        interval: false,
        wrap: false
    });

    function updateUI() {
        const total = $dots.length;
        const index = $carousel.find('.carousel-item.active').index();

        // Update dots
        $dots.removeClass('active');
        $dots.each(function (i) {
            if (i <= index) $(this).addClass('active');
        });

        // Update line fill
        const guideWidth = $('.progress-guide').width();
        const leftOffset = 15;
        const percent = (index / (total - 1));
        const fillWidth = ((guideWidth - leftOffset * 2) * percent);
        $lineFill.css('width', fillWidth + 'px');

        // Update buttons
        $('#prevBtn').prop('disabled', index === 0);
        if (index === total - 1) {
            $('#nextBtn').text('Save').removeClass('btn-primary').addClass('btn-success');
        } else {
            $('#nextBtn').text('Next').removeClass('btn-success').addClass('btn-primary');
        }
    }

    $('#nextBtn').click(function () {
        const index = $carousel.find('.carousel-item.active').index();
        const lastIndex = $dots.length - 1;

        if (index === lastIndex) {
            const toast = new bootstrap.Toast($('#successToast')[0]);
            toast.show();
            $('#slidePulloutModal').modal('hide');
        } else {
            carousel.next();
        }
    });

    $('#prevBtn').click(function () {
        carousel.prev();
    });

    $carousel.on('slid.bs.carousel', updateUI);

    // Force reset on modal open (before shown)
    $('#slidePulloutModal').on('show.bs.modal', function () {
        resetSlides();
    });

    function resetSlides() {
        // Reset carousel to first slide
        $carousel.find('.carousel-item').removeClass('active');
        $carousel.find('.carousel-item').first().addClass('active');

        // Reset progress
        $dots.removeClass('active');
        $dots.first().addClass('active');
        $lineFill.css('width', '0');

        // Reset buttons
        $('#prevBtn').prop('disabled', true);
        $('#nextBtn').text('Next').removeClass('btn-success').addClass('btn-primary');

        // Recreate Carousel instance to fix Bootstrap's internal index tracker
        carousel.dispose();
        carousel = new bootstrap.Carousel($carousel[0], {
            interval: false,
            wrap: false
        });

        // Manually update UI
        updateUI();
    }

    $(document).on("change", "#checkDefault", function () {
        var isChecked = $(this).is(":checked");
        $(".hardware-checkbox").prop("checked", isChecked);
    });

    $(document).on("change", ".hardware-checkbox", function () {
        if (!$(this).is(":checked")) {
            $("#checkDefault").prop("checked", false);
        } else {
            // If all checkboxes are now checked, check the master box too
            const allChecked = $(".hardware-checkbox").length === $(".hardware-checkbox:checked").length;
            $("#checkDefault").prop("checked", allChecked);
        }
    });

    // Load site list on page load
    $.ajax({
        type: "POST",
        url: "request-pullout.php",
        data: { action: "view_sites" },
        success: function(response) {
            console.log("RAW RESPONSE:", response);
            try {
                var sites = JSON.parse(response);
                var $select = $("select[name='site_list']");
                $select.empty();
                $select.append('<option value="" selected disabled>Select a site</option>');

                sites.forEach(function(site) {
                    $select.append('<option value="' + site.site_code + '">' + site.site_code + " - " + site.site_name + '</option>');
                });
            } catch (e) {
                console.error("JSON parse failed:", e.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });

// Show hardware for selected site and type
    let selectedHardware = {};
    let lastSiteSelected = null;

// Handle 'Select All' checkbox
    $('#selectAllHardware').on('change', function () {
        const isChecked = this.checked;
        $('.hardware-checkbox').each(function () {
            $(this).prop('checked', isChecked).trigger('change');
        });
    });

// Show hardware when button is clicked
    $("#show-hardware").click(function () {
        const selectedSite = $("select[name='site_list']").val();

        // Reset selection if site is changed
        if (lastSiteSelected !== selectedSite) {
            selectedHardware = {};
            lastSiteSelected = selectedSite;
        }

        // Destroy previous DataTable
        if ($.fn.DataTable.isDataTable('#hardwareToPullout')) {
            $('#hardwareToPullout').DataTable().destroy();
        }

        // Fetch hardware list
        const requestData = {
            action: "view_hardware",
            hw_type: $("select[name='hw_type']").val(),
            site_list: selectedSite
        };

        $.ajax({
            type: "POST",
            url: "request-pullout.php",
            data: requestData,
            success: function (response) {
                console.log("Hardware response:", response);
                try {
                    const hardware = JSON.parse(response);
                    const tbody = $("#hardwareToPulloutDisplay");
                    tbody.empty();

                    // Append selected hardware rows first
                    Object.values(selectedHardware).forEach(item => {
                        tbody.append(`
                        <tr class="table-primary">
                            <td>${item.hw_brand_name}</td>
                            <td>${item.hw_model}</td>
                            <td>${item.hw_asset_num}</td>
                            <td>${item.hw_serial_num}</td>
                            <td style="text-align: center;">
                                <input type="checkbox" class="form-check-input hardware-checkbox" 
                                    data-id="${item.hw_id}" 
                                    data-brand="${item.hw_brand_name}" 
                                    data-model="${item.hw_model}" 
                                    data-asset="${item.hw_asset_num}" 
                                    data-serial="${item.hw_serial_num}" checked>
                            </td>
                        </tr>
                    `);
                    });

                    // Append new hardware rows if not already selected
                    hardware.forEach(item => {
                        if (!selectedHardware[item.hw_id]) {
                            tbody.append(`
                            <tr>
                                <td>${item.hw_brand_name}</td>
                                <td>${item.hw_model}</td>
                                <td>${item.hw_asset_num}</td>
                                <td>${item.hw_serial_num}</td>
                                <td style="text-align: center;">
                                    <input type="checkbox" class="form-check-input hardware-checkbox" 
                                        data-id="${item.hw_id}" 
                                        data-brand="${item.hw_brand_name}" 
                                        data-model="${item.hw_model}" 
                                        data-asset="${item.hw_asset_num}" 
                                        data-serial="${item.hw_serial_num}">
                                </td>
                            </tr>
                        `);
                        }
                    });

                    // Bind checkbox change events with highlight
                    $('.hardware-checkbox').off('change').on('change', function () {
                        const id = $(this).data('id');
                        const row = $(this).closest('tr');

                        if (this.checked) {
                            row.addClass('table-primary');
                            selectedHardware[id] = {
                                hw_id: id,
                                hw_brand_name: $(this).data('brand'),
                                hw_model: $(this).data('model'),
                                hw_asset_num: $(this).data('asset'),
                                hw_serial_num: $(this).data('serial')
                            };
                        } else {
                            row.removeClass('table-primary');
                            delete selectedHardware[id];
                        }

                        // Update 'Select All' checkbox state
                        const allChecked = $('.hardware-checkbox').length === $('.hardware-checkbox:checked').length;
                        $('#selectAllHardware').prop('checked', allChecked);
                    });

                    // Reinitialize DataTable if needed
                    $('#hardwareToPullout').DataTable();

                } catch (e) {
                    console.error("JSON parsing failed:", e.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });


});