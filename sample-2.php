<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Model Visualization</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Card Styling */
        .card {
            border-radius: 10px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            padding: 12px;
            max-width: 400px;
            margin: auto;
        }

        /* Color Blocks Container */
        .color-blocks {
            display: flex;
            width: 100%;
            height: 12px; /* Adjusted height to be thinner */
            border-radius: 6px;
            overflow: hidden;
        }

        /* Server Data Section */
        .server-data {
            margin-top: 8px;
        }

        .server-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: 500;
        }

        .server-item hr {
            margin: 3px 0;
            border: 0;
            height: 1px;
            background-color: #ddd;
        }

        /* Legend Styling */
        .legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }
    </style>
</head>
<body>

<div class="container mt-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h6 class="text-center mb-2">Server Model Distribution</h6>

            <!-- Color Block Visualization -->
            <div class="color-blocks" id="colorBlocks"></div>

            <!-- Server Data Table -->
            <div class="server-data" id="serverData"></div>

            <!-- Legend -->
            <div class="legend" id="legend"></div>

        </div>
    </div>
</div>

<script>
    // Data for servers
    const serverData = [
        { name: "Xitrix", count: 45, color: "#ff5733" },
        { name: "IBM", count: 109, color: "#1f77b4" },
        { name: "Dell", count: 10, color: "#28a745" },
        { name: "HP Proliant G9", count: 89, color: "#ffc107" },
        { name: "HP Proliant G10", count: 56, color: "#6f42c1" },
        { name: "HP Proliant G11", count: 35, color: "#fd7e14" }
    ];

    // Populate color blocks
    const colorBlocks = document.getElementById("colorBlocks");
    serverData.forEach(server => {
        const block = document.createElement("div");
        block.style.flex = server.count; // Adjust width based on data
        block.style.backgroundColor = server.color;
        block.classList.add("color-block");
        colorBlocks.appendChild(block);
    });

    // Populate server data table
    const serverDataContainer = document.getElementById("serverData");
    serverData.forEach(server => {
        const item = document.createElement("div");
        item.classList.add("server-item");
        item.innerHTML = `<span><strong>${server.name}</strong></span> <span>${server.count}</span>`;
        serverDataContainer.appendChild(item);
        serverDataContainer.appendChild(document.createElement("hr"));
    });

    // Populate legend
    const legendContainer = document.getElementById("legend");
    serverData.forEach(server => {
        const legendItem = document.createElement("div");
        legendItem.classList.add("legend-item");
        legendItem.innerHTML = `<div class="legend-color" style="background-color: ${server.color};"></div> ${server.name}`;
        legendContainer.appendChild(legendItem);
    });
</script>

</body>
</html>
