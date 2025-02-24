$(function(){
    let ageChart;       // Global variable for Age (doughnut) chart instance
    let categoryChart;  // Global variable for Category (bar) chart instance

    // Function to load dashboard data with an optional region filter
    function loadDashboard(region = "all") {
        $.ajax({
            type: "POST",
            url: "dashboard-charts.php",
            data: { region: region }, // send region filter value to PHP
            dataType: "json",
            success: function (data){
                console.log("Dashboard Data:", data);

                // Populate Tables
                populateTable("#hardwareTable", data.hardware);
                populateServerTable("#serverModelTable", data.server_models); // Display Server Table
                populatePrinterTable("#printerModelTable", data.printer_models); // Display Printer Table
                populateOSTypeTable("#osTypeTable", data.os_type); // Display OS Type Table

                // Destroy existing charts if they exist to force an immediate redraw with new data
                if (categoryChart) {
                    categoryChart.destroy();
                }
                if (ageChart) {
                    ageChart.destroy();
                }

                // Initialize Charts with new data
                categoryChart = initializeCategoryChart(data);
                ageChart = initializeAgeChart(data);

                // Event Listener for Hardware Filter (if needed)
                $("#hardwareFilter").off("change").on("change", function() {
                    var selectedHardware = $("select[name='hardwareFilter']").val();
                    filterAgeChart(data, selectedHardware);
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    }

    // Load dashboard data on page load (with region filter "all")
    loadDashboard();

    // Event listener for Region Filter dropdown
    $("#regionFilter").on("change", function() {
        var selectedRegion = $(this).val();
        loadDashboard(selectedRegion);
    });

    // Table population functions
    function populateTable(tableId, data) {
        const tableBody = $(tableId).find("tbody");
        tableBody.empty();
        data.forEach(item => {
            tableBody.append(`<tr><td>${item.sub_major_type}</td><td>${item.item_desc}</td><td>${item.count}</td></tr>`);
        });
    }

    function populateServerTable(tableId, data) {
        const tableBody = $(tableId).find("tbody");
        tableBody.empty();
        data.forEach(item => {
            tableBody.append(`
                <tr>
                    <td>${item.hw_brand_name}</td>
                    <td>${item.hw_model}</td>
                    <td>${item.count}</td>
                </tr>
            `);
        });
    }

    function populatePrinterTable(tableId, data) {
        const tableBody = $(tableId).find("tbody");
        tableBody.empty();
        data.forEach(item => {
            tableBody.append(`
                <tr>
                    <td>${item.hw_brand_name}</td>
                    <td>${item.hw_model}</td>
                    <td>${item.count}</td>
                </tr>
            `);
        });
    }

    function populateOSTypeTable(tableId, data) {
        const tableBody = $(tableId).find("tbody");
        tableBody.empty();
        data.forEach(item => {
            tableBody.append(`
                <tr>
                    <td>${item.os_type}</td>
                    <td>${item.count}</td>
                </tr>
            `);
        });
    }

    // Chart initialization functions
    function initializeCategoryChart(data) {
        const categoryCanvas = document.getElementById("categoryChart");
        if (!categoryCanvas) {
            console.error("Canvas element not found");
            return;
        }

        return new Chart(categoryCanvas, {
            type: "bar",
            data: {
                labels: data.category_name,
                datasets: [{
                    label: "Hardware",
                    data: data.category_count,
                    backgroundColor: "rgba(153, 102, 255, 0.6)",
                    borderColor: "rgba(153, 102, 255, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                animation: { duration: 1000 },
                hover: { animationDuration: 1000 },
                plugins: {
                    legend: { position: "top" },
                    title: { display: true, text: "Devices by Category" }
                }
            }
        });
    }

    function initializeAgeChart(data) {
        const ageCanvas = document.getElementById("ageChart");
        if (!ageCanvas) {
            console.error("Canvas element not found");
            return null;
        }

        return new Chart(ageCanvas, {
            type: "doughnut",
            data: {
                labels: data.age_labels,
                datasets: [{
                    label: "Age of Hardware",
                    data: data.age_data,
                    backgroundColor: [
                        "rgba(75, 192, 192, 0.6)",
                        "rgba(54, 162, 235, 0.6)",
                        "rgba(255, 206, 86, 0.6)",
                        "rgba(255, 99, 132, 0.6)",
                        "rgba(153, 102, 255, 0.6)"
                    ],
                    borderColor: [
                        "rgba(75, 192, 192, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(255, 99, 132, 1)",
                        "rgba(153, 102, 255, 1)"
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                animation: { duration: 1000 },
                hover: { animationDuration: 1000 },
                plugins: {
                    legend: { position: "top" },
                    title: { display: true, text: "Age of Hardware" }
                }
            }
        });
    }

    function filterAgeChart(data, selectedHardware) {
        console.log("Selected Hardware:", selectedHardware);

        if (!ageChart) {
            console.error("Chart instance not found");
            return;
        }

        const filteredData = data.all_hardware.filter(item => {
            return selectedHardware === "all" || item.sub_major_type.trim() === selectedHardware.trim();
        });

        console.log("Filtered Data:", filteredData);

        // Include "Unknown Age" in the age categories
        const ageData = {
            '3 Years below': 0,
            '3-5 Years': 0,
            '5-10 Years': 0,
            '10 Years above': 0,
            'Unidentified Age': 0
        };

        const currentYear = new Date().getFullYear();
        filteredData.forEach(item => {
            // If hw_date_acq is missing or invalid, count as Unknown Age
            if (!item.hw_date_acq || isNaN(new Date(item.hw_date_acq).getFullYear())) {
                ageData['Unidentified Age']++;
                return;
            }

            let yearAcq = new Date(item.hw_date_acq).getFullYear();
            const age = currentYear - yearAcq;

            if (age <= 3) {
                ageData['3 Years below']++;
            } else if (age <= 5) {
                ageData['3-5 Years']++;
            } else if (age <= 10) {
                ageData['5-10 Years']++;
            } else {
                ageData['10 Years above']++;
            }
        });

        console.log("Updated Age Data:", ageData);

        // If all values are 0, set dummy data to prevent chart from disappearing
        if (Object.values(ageData).every(value => value === 0)) {
            console.warn("No data available for selected hardware.");
            ageData['No Data'] = 1;
        }

        ageChart.destroy();

        ageChart = new Chart(document.getElementById("ageChart"), {
            type: "doughnut",
            data: {
                labels: Object.keys(ageData),
                datasets: [{
                    label: "Age of Hardware",
                    data: Object.values(ageData),
                    backgroundColor: [
                        "rgba(75, 192, 192, 0.6)",
                        "rgba(54, 162, 235, 0.6)",
                        "rgba(255, 206, 86, 0.6)",
                        "rgba(255, 99, 132, 0.6)",
                        "rgba(153, 102, 255, 0.6)"
                    ],
                    borderColor: [
                        "rgba(75, 192, 192, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(255, 99, 132, 1)",
                        "rgba(153, 102, 255, 1)"
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                animation: { duration: 1000 },
                hover: { animationDuration: 1000 },
                plugins: {
                    legend: { position: "top" },
                    title: { display: true, text: "Age of Hardware" }
                }
            }
        });

        console.log("Chart updated!");
    }
});
