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
                populateServerTable("#serverModelTable", data.server_models); // Server Table
                populatePrinterTable("#printerModelTable", data.printer_models); // Printer Table
                populateOSTypeTable("#osTypeTable", data.os_type); // OS Type Table

                // Destroy existing charts if they exist
                if (categoryChart) { categoryChart.destroy(); }
                if (ageChart) { ageChart.destroy(); }

                // Initialize Charts with new data from PHP
                categoryChart = initializeCategoryChart(data);
                ageChart = initializeAgeChart(data);

                // Event Listener for Hardware Filter on Age Chart
                $("#hardwareFilter").off("change").on("change", function() {
                    var selectedHardware = $(this).val();
                    filterAgeChart(data, selectedHardware);
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    // Load dashboard data on page load
    loadDashboard();

    // Event listener for Region Filter dropdown
    $("#regionFilter").on("change", function() {
        var selectedRegion = $(this).val();
        loadDashboard(selectedRegion);
    });

    // Table population functions
    function populateTable(tableId, data) {
        const tbody = $(tableId).find("tbody");
        tbody.empty();
        data.forEach(item => {
            tbody.append(`<tr><td>${item.sub_major_type}</td><td>${item.item_desc}</td><td>${item.count}</td></tr>`);
        });
    }
    function populateServerTable(tableId, data) {
        const tbody = $(tableId).find("tbody");
        tbody.empty();
        data.forEach(item => {
            tbody.append(`<tr><td>${item.hw_brand_name}</td><td>${item.hw_model}</td><td>${item.count}</td></tr>`);
        });
    }
    function populatePrinterTable(tableId, data) {
        const tbody = $(tableId).find("tbody");
        tbody.empty();
        data.forEach(item => {
            tbody.append(`<tr><td>${item.hw_brand_name}</td><td>${item.hw_model}</td><td>${item.count}</td></tr>`);
        });
    }
    function populateOSTypeTable(tableId, data) {
        const tbody = $(tableId).find("tbody");
        tbody.empty();
        data.forEach(item => {
            tbody.append(`<tr><td>${item.os_type}</td><td>${item.count}</td></tr>`);
        });
    }

    // Chart initialization functions
    function initializeCategoryChart(data) {
        const canvas = document.getElementById("categoryChart");
        if (!canvas) { console.error("Canvas element not found"); return; }
        return new Chart(canvas, {
            type: "bar",
            data: {
                labels: data.category_name,
                datasets: [{
                    label: "Hardware",
                    data: data.category_count,
                    backgroundColor: "rgba(153,102,255,0.6)",
                    borderColor: "rgba(153,102,255,1)",
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
        const canvas = document.getElementById("ageChart");
        if (!canvas) { console.error("Canvas element not found"); return null; }
        return new Chart(canvas, {
            type: "doughnut",
            data: {
                labels: data.age_labels,
                datasets: [{
                    label: "Age of Hardware",
                    data: data.age_data,
                    backgroundColor: [
                        "rgba(75,192,192,0.6)",
                        "rgba(54,162,235,0.6)",
                        "rgba(255,206,86,0.6)",
                        "rgba(255,99,132,0.6)",
                        "rgba(153,102,255,0.6)"
                    ],
                    borderColor: [
                        "rgba(75,192,192,1)",
                        "rgba(54,162,235,1)",
                        "rgba(255,206,86,1)",
                        "rgba(255,99,132,1)",
                        "rgba(153,102,255,1)"
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

    // Filter Age Chart based on hardware filter selection
    function filterAgeChart(data, selectedHardware) {
        console.log("Selected Hardware:", selectedHardware);
        if (!ageChart) { console.error("Chart instance not found"); return; }

        // If "all" is selected, revert to the original PHP data.
        if (selectedHardware === "all") {
            ageChart.destroy();
            ageChart = new Chart(document.getElementById("ageChart"), {
                type: "doughnut",
                data: {
                    labels: data.age_labels,
                    datasets: [{
                        label: "Age of Hardware",
                        data: data.age_data,
                        backgroundColor: [
                            "rgba(75,192,192,0.6)",
                            "rgba(54,162,235,0.6)",
                            "rgba(255,206,86,0.6)",
                            "rgba(255,99,132,0.6)",
                            "rgba(153,102,255,0.6)"
                        ],
                        borderColor: [
                            "rgba(75,192,192,1)",
                            "rgba(54,162,235,1)",
                            "rgba(255,206,86,1)",
                            "rgba(255,99,132,1)",
                            "rgba(153,102,255,1)"
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
            console.log("Age Chart reset to original data!");
            return;
        }

        // Otherwise, filter the all_hardware array for the selected type.
        let filtered = data.all_hardware.filter(item => {
            return item.sub_major_type.trim().toLowerCase() === selectedHardware.trim().toLowerCase();
        });
        console.log("Filtered hardware:", filtered);

        // Recompute age data from the filtered array
        let ageData = {
            '3 Years below': 0,
            '3-5 Years': 0,
            '5-10 Years': 0,
            '10 Years above': 0,
            'Unidentified Age': 0
        };
        const currentYear = new Date().getFullYear();
        filtered.forEach(item => {
            if (!item.hw_date_acq || isNaN(new Date(item.hw_date_acq).getFullYear())) {
                ageData['Unidentified Age']++;
            } else {
                let yearAcq = new Date(item.hw_date_acq).getFullYear();
                let age = currentYear - yearAcq;
                if (age <= 3) {
                    ageData['3 Years below']++;
                } else if (age <= 5) {
                    ageData['3-5 Years']++;
                } else if (age <= 10) {
                    ageData['5-10 Years']++;
                } else {
                    ageData['10 Years above']++;
                }
            }
        });
        console.log("Updated Age Data:", ageData);

        ageChart.destroy();
        ageChart = new Chart(document.getElementById("ageChart"), {
            type: "doughnut",
            data: {
                labels: Object.keys(ageData),
                datasets: [{
                    label: "Age of Hardware",
                    data: Object.values(ageData),
                    backgroundColor: [
                        "rgba(75,192,192,0.6)",
                        "rgba(54,162,235,0.6)",
                        "rgba(255,206,86,0.6)",
                        "rgba(255,99,132,0.6)",
                        "rgba(153,102,255,0.6)"
                    ],
                    borderColor: [
                        "rgba(75,192,192,1)",
                        "rgba(54,162,235,1)",
                        "rgba(255,206,86,1)",
                        "rgba(255,99,132,1)",
                        "rgba(153,102,255,1)"
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
        console.log("Age Chart updated with filtered data!");
    }
});
