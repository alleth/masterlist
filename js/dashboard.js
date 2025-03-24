$(function() {
    let ageChart;
    let categoryChart;

    function loadDashboard(region = "all") {
        console.log("Loading dashboard for region:", region);
        $.ajax({
            type: "POST",
            url: "dashboard-charts.php",
            data: { region: region },
            dataType: "json",
            success: function(data) {
                console.log("Received Data:", data);

                if (data.error) {
                    console.error("Server Error:", data.error);
                    alert("Error: " + data.error);
                    return;
                }

                // Log data specifics
                console.log("Hardware Count:", data.all_hardware ? data.all_hardware.length : 0);
                console.log("Categories:", data.category_name);

                // Populate Tables
                populateTable("#hardwareTable", data.hardware || []);
                populateServerTable("#serverModelTable", data.server_models || []);
                populatePrinterTable("#printerModelTable", data.printer_models || []);
                populateOSTypeTable("#osTypeTable", data.os_type || []);

                // Initialize Charts
                if (categoryChart) categoryChart.destroy();
                if (ageChart) ageChart.destroy();

                categoryChart = initializeCategoryChart(data);
                ageChart = initializeAgeChart(data);

                $("#hardwareFilter").off("change").on("change", function() {
                    filterAgeChart(data, $(this).val());
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
                alert("Failed to load dashboard data. Check console for details.");
            }
        });
    }

    loadDashboard();

    $("#regionFilter").on("change", function() {
        loadDashboard($(this).val());
    });

    function populateTable(tableId, data) {
        const tbody = $(tableId + " tbody");
        tbody.empty();
        if (!data || !data.length) tbody.append("<tr><td colspan='3'>No data available</td></tr>");
        else data.forEach(item => tbody.append(`<tr><td>${item.sub_major_type}</td><td>${item.item_desc || "N/A"}</td><td>${item.count}</td></tr>`));
    }

    function populateServerTable(tableId, data) {
        const tbody = $(tableId + " tbody");
        tbody.empty();
        if (!data || !data.length) tbody.append("<tr><td colspan='3'>No data available</td></tr>");
        else data.forEach(item => tbody.append(`<tr><td>${item.hw_brand_name}</td><td>${item.hw_model}</td><td>${item.count}</td></tr>`));
    }

    function populatePrinterTable(tableId, data) {
        const tbody = $(tableId + " tbody");
        tbody.empty();
        if (!data || !data.length) tbody.append("<tr><td colspan='3'>No data available</td></tr>");
        else data.forEach(item => tbody.append(`<tr><td>${item.hw_brand_name}</td><td>${item.hw_model}</td><td>${item.count}</td></tr>`));
    }

    function populateOSTypeTable(tableId, data) {
        const tbody = $(tableId + " tbody");
        tbody.empty();
        if (!data || !data.length) tbody.append("<tr><td colspan='2'>No data available</td></tr>");
        else data.forEach(item => tbody.append(`<tr><td>${item.os_type}</td><td>${item.count}</td></tr>`));
    }

    function initializeCategoryChart(data) {
        const ctx = document.getElementById("categoryChart");
        if (!ctx) { console.error("Category Chart canvas not found"); return null; }
        return new Chart(ctx.getContext("2d"), {
            type: "bar",
            data: {
                labels: data.category_name && data.category_name.length ? data.category_name : ["No Categories"],
                datasets: [{
                    label: "Hardware",
                    data: data.category_count && data.category_count.length ? data.category_count : [0],
                    backgroundColor: "rgba(153,102,255,0.6)",
                    borderColor: "rgba(153,102,255,1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: "top" }, title: { display: true, text: "Devices by Category" } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    function initializeAgeChart(data) {
        const ctx = document.getElementById("ageChart");
        if (!ctx) { console.error("Age Chart canvas not found"); return null; }
        const labels = data.age_labels && data.age_labels.length ? data.age_labels : ["No Data"];
        const chartData = data.age_data && data.age_data.length ? data.age_data : [1];
        return new Chart(ctx.getContext("2d"), {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [{
                    label: "Age of Hardware",
                    data: chartData,
                    backgroundColor: data.age_data && data.age_data.length
                        ? ["rgba(75,192,192,0.6)", "rgba(54,162,235,0.6)", "rgba(255,206,86,0.6)", "rgba(255,99,132,0.6)", "rgba(153,102,255,0.6)"]
                        : ["rgba(200,200,200,0.6)"],
                    borderColor: data.age_data && data.age_data.length
                        ? ["rgba(75,192,192,1)", "rgba(54,162,235,1)", "rgba(255,206,86,1)", "rgba(255,99,132,1)", "rgba(153,102,255,1)"]
                        : ["rgba(200,200,200,1)"],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: "top" }, title: { display: true, text: "Age of Hardware" } }
            }
        });
    }

    function filterAgeChart(data, selectedHardware) {
        console.log("Filtering for:", selectedHardware);
        if (!ageChart) { console.error("Age Chart not initialized"); return; }

        let filtered = selectedHardware === "all"
            ? data.all_hardware
            : data.all_hardware.filter(item => item.sub_major_type === selectedHardware);

        console.log("Filtered Hardware:", filtered);

        let ageData = {
            '3 Years below': 0, '3-5 Years': 0, '5-10 Years': 0,
            '10 Years above': 0, 'Unidentified Age': 0
        };
        const currentYear = new Date().getFullYear();

        filtered.forEach(item => {
            if (!item.hw_date_acq || isNaN(Date.parse(item.hw_date_acq))) {
                ageData['Unidentified Age']++;
            } else {
                let yearAcq = new Date(item.hw_date_acq).getFullYear();
                let age = currentYear - yearAcq;
                if (age <= 3) ageData['3 Years below']++;
                else if (age <= 5) ageData['3-5 Years']++;
                else if (age <= 10) ageData['5-10 Years']++;
                else ageData['10 Years above']++;
            }
        });

        console.log("New Age Data:", ageData);

        ageChart.destroy();
        ageChart = new Chart(document.getElementById("ageChart").getContext("2d"), {
            type: "doughnut",
            data: {
                labels: Object.keys(ageData),
                datasets: [{
                    label: "Age of Hardware",
                    data: Object.values(ageData),
                    backgroundColor: ["rgba(75,192,192,0.6)", "rgba(54,162,235,0.6)", "rgba(255,206,86,0.6)", "rgba(255,99,132,0.6)", "rgba(153,102,255,0.6)"],
                    borderColor: ["rgba(75,192,192,1)", "rgba(54,162,235,1)", "rgba(255,206,86,1)", "rgba(255,99,132,1)", "rgba(153,102,255,1)"],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: "top" }, title: { display: true, text: `Age of ${selectedHardware === "all" ? "All" : selectedHardware} Hardware` } }
            }
        });
    }
});