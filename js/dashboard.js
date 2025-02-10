$(function(){
    $.ajax({
        type: "POST",
        url: "dashboard-charts.php",
        dataType: "json",
        success: function (data){
            console.log("Chart Data:", data);

            // Check if data is received correctly
            if (!data.hardware) {
                console.error("No data for hardware table");
                return;
            }

            // Populate Hardware Table
            populateTable("#hardwareTable", data.hardware);

            // Existing chart code
            if (!data.category_name || !data.category_count) {
                console.error("No data for category chart");
                return;
            }

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
                        backgroundColor: "rgba(153, 102, 255, 0.6)", // Apply same color
                        borderColor: "rgba(153, 102, 255, 1)", // Apply same color
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

            // Age of Hardware Chart
            if (!data.age_labels || !data.age_data) {
                console.error("No data for age chart");
                return;
            }

            const ageCanvas = document.getElementById("ageChart");

            if (!ageCanvas) {
                console.error("Canvas element not found");
                return;
            }

            new Chart(ageCanvas, {
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
});
