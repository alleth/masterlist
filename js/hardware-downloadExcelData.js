document.addEventListener("DOMContentLoaded", function () {
  const downloadButton = document.getElementById("downloadButton");

  downloadButton.addEventListener("click", function () {
    const siteCode = document.getElementById("downloadSiteSelect").value;

    if (!siteCode) {
      alert("Please select a site before downloading.");
      return;
    }

    const downloadUrl = `hardware-download-csv-data.php?site_code=${encodeURIComponent(siteCode)}`;

    // Create and trigger a temporary download link
    const tempLink = document.createElement("a");
    tempLink.href = downloadUrl;
    tempLink.style.display = "none";
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);
  });
});
