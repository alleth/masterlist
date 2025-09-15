// Load regions into dropdown when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    loadRegionOptions();
});

function loadRegionOptions() {
    fetch('facilities-select-region.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("regionSelect");
            select.innerHTML = '<option value="all">All Region</option>';
            data.forEach(region => {
                const option = document.createElement("option");
                option.value = region.region_id;
                option.textContent = region.region_name;
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error loading regions:", error));
}

$(document).ready(function () {
    $("#showFacButton").on("click", function () {
        let region = $("#regionSelect").val();

        $.ajax({
            url: "facilities-show.php",
            method: "POST",
            data: { region: region },
            success: function (response) {
                $("#facilitiesDisplay").html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
                alert("Failed to load data.");
            }
        });
    });
});

// for debugging
$(document).ready(function () {
    $("#showFacButton").on("click", function () {
        let region = $("#regionSelect").val();
        console.log("Selected region:", region); // debug log

        $.ajax({
            url: "facilities-show.php",
            method: "POST",
            data: { region: region },
            success: function (response) {
                console.log("AJAX success. Response:", response); // debug log
                $("#facilitiesDisplay").html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
                alert("Failed to load data.");
            }
        });
    });
});





