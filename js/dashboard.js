$(function(){
    let ageChart; // Store chart instance globally

    $.ajax({
        type: "POST",
        url: "dashboard-charts.php",
        dataType: "json",
        success: function (data){
            console.log("Chart Data:", data);

            // Populate Hardware Table
            populateTable("#hardwareTable", data.hardware);
            populateServerTable("#serverModelTable", data.server_models); // Display Server Function
            populatePrinterTable("#printerModelTable", data.printer_models); // Display Printer Function

            // Initialize Charts
            initializeCategoryChart(data);
            ageChart = initializeAgeChart(data);

            // Event Listener for Hardware Filter
            $("#hardwareFilter").on("change", function() {
                var selectedHardware = $("select[name='hardwareFilter']").val();
                filterAgeChart(data, selectedHardware);
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", status, error);
        }
    });

    function populateTable(tableId, data) {
        const tableBody = $(tableId).find("tbody");
        tableBody.empty();
        data.forEach(item => {
            tableBody.append(`<tr><td>${item.sub_major_type}</td><td>${item.item_desc}</td><td>${item.count}</td></tr>`);
        });
    }

    function initializeCategoryChart(data) {
        const categoryCanvas = document.getElementById("categoryChart");
        if (!categoryCanvas) {
            console.error("Canvas element not found");
            return;
        }

        new Chart(categoryCanvas, {
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

        const ageData = {
            '3 Years below': 0,
            '3-5 Years': 0,
            '5-10 Years': 0,
            '10 Years above': 0
        };

        const currentYear = new Date().getFullYear();
        filteredData.forEach(item => {
            if (!item.hw_date_acq) {
                console.warn("Missing acquisition date for item:", item);
                return;
            }

            let yearAcq = new Date(item.hw_date_acq).getFullYear();
            if (isNaN(yearAcq)) {
                console.warn("Invalid acquisition date:", item.hw_date_acq);
                return;
            }

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

        // If all values are 0, prevent chart from disappearing by setting dummy data
        if (Object.values(ageData).every(value => value === 0)) {
            console.warn("No data available for selected hardware.");
            ageData['No Data'] = 1; // Prevents chart from disappearing
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
                plugins: {
                    legend: { position: "top" },
                    title: { display: true, text: "Age of Hardware" }
                }
            }
        });

        console.log("Chart updated!");
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
});
