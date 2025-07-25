    //- Enable the show button when the region is Selected
    $(document).ready(function () {
        $('#CpuPCRegionSelect').on('change', function () {
            const selectedRegion = $(this).val();

            if (selectedRegion) {
                // Enable the Show button
                $('#showCPUPCButton').prop('disabled', false);
            } else {
                // Disable if no region is selected (optional fallback)
                $('#showCPUPCButton').prop('disabled', true);
            }
        });
    });

    //---s
    $(document).ready(function () {
        $("#showCPUPCButton").on("click", function (e) {
            e.preventDefault(); // Prevent any default form behavior

            const tbody = $("#hardwareDisplay");

            // Show loading spinner
            tbody.html(`
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2 text-muted fst-italic">Loading CPU-PC records...</div>
                    </td>
                </tr>
            `);

            // Fetch data via AJAX
            $.ajax({
                url: 'hardware-cpupc-details.php',
                method: 'POST',
                data: {}, // No filters; fetch all CPU-PC records
                success: function (response) {
                    if ($.trim(response) === "") {
                        tbody.html(`
                            <tr>
                                <td colspan="8" class="text-muted text-center fst-italic">No CPU-PC records found.</td>
                            </tr>
                        `);
                    } else {
                        tbody.html(response);
                    }
                },
                error: function () {
                    tbody.html(`
                        <tr>
                            <td colspan="8" class="text-danger text-center">An error occurred while fetching data.</td>
                        </tr>
                    `);
                }
            });
        });
    });





