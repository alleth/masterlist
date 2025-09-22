// Load Regions (and then auto-load sites for the first region)
function loadFilters() {
    $.getJSON('dashboardv3-filters.php', { type: 'region' }, function(data) {
        let $dbregionSelect = $('#dbregionSelect');
        $dbregionSelect.empty().append('<option value="">All Regions</option>');
        
        data.forEach(function(region) {
            $dbregionSelect.append(
                $('<option>', { value: region.region_id, text: region.region_name })
            );
        });

        let firstRegion = $dbregionSelect.val();
        loadSites(firstRegion);
    });
}

// Load Sites based on region
function loadSites(regionId) {
    $.getJSON('dashboardv3-filters.php', { type: 'site', region_id: regionId }, function(data) {
        let $site = $('#dbsiteSelect');
        $site.empty().append('<option value="">All Sites</option>');
        data.forEach(function(site) {
            $site.append(
                $('<option>', { value: site.site_code, text: site.site_code + ' - ' + site.site_name })
            );
        });

         toggleCards();
         
    });
}

function loadDashboardCounts() {
    const region = $('#dbregionSelect').val();
    const site = $('#dbsiteSelect').val();

    $.ajax({
        url: 'dashboardv3-hardware-data.php',
        method: 'GET',
        data: { region: region, site: site },
        dataType: 'json',
        success: function(data) {
            $('#serverCount').text(data.server_count ?? 0);
            $('#serverCount2').text(data.server2_count ?? 0);

            $('#serverHpCount').text(data.server_hp_count ?? 0);
            $('#serverIbmCount').text(data.server_ibm_count ?? 0);
            $('#serverXitrixCount').text(data.server_xitrix_count ?? 0);
            $('#serverDellCount').text(data.server_dell_count ?? 0);
            $('#serverLenovoCount').text(data.server_lenovo_count ?? 0);
            $('#VMServerCount').text(data.vm_server_count ?? 0);

            $('#cpuPcCount').text(data.cpu_pc_count ?? 0);
            $('#xpCount').text(data.xp_count ?? 0);
            $('#w1032bitCount').text(data.w1032bit_count ?? 0);
            $('#w1064bitCount').text(data.w1064bit_count ?? 0);
            $('#w11Count').text(data.w11_count ?? 0);

            $('#monitorCount').text(data.monitor_count ?? 0);
            $('#keyboardCount').text(data.keybpard_count ?? 0);
            $('#mouseCount').text(data.mouse_count ?? 0);
            $('#webcamCount').text(data.webcam_count ?? 0);
            $('#sigpadCount').text(data.sigpad_count ?? 0);
            $('#posCount').text(data.pos_count ?? 0);
            $('#LCDDisplayCount').text(data.LCD_Display_count ?? 0);
            $('#cashDrawerCount').text(data.cash_drawer_count ?? 0);
            $('#totalCount').text(data.total_count ?? 0);

            $('#rsuCount').text(data.rsu_count ?? 0);
            $('#mvdtoCount').text(data.mvdto_count ?? 0);
            $('#mvmaintCount').text(data.mvmaint_count ?? 0);
            $('#imsaiuCount').text(data.imsaiu_count ?? 0);
            $('#dldtoCount').text(data.dldto_count ?? 0);
            $('#dlmaintCount').text(data.dlmaint_count ?? 0);

            $('#switchCount').text(data.switch_count ?? 0);
            $('#sdwanCount').text(data.sdwan_count ?? 0);
            $('#routerCount').text(data.router_count ?? 0);

            $('#laserjetCount').text(data.laserjet_count ?? 0);
            $('#dotmatrixCount').text(data.dotmatrix_count ?? 0);
            $('#inkjetCount').text(data.inkjet_count ?? 0);
            $('#deskjetCount').text(data.deskjet_count ?? 0);

            $('#4100Count').text(data.l4100_count ?? 0);
            $('#507Count').text(data.l507_count ?? 0);
            $('#lx300Count').text(data.lx300_count ?? 0);
            $('#l310Count').text(data.l310_count ?? 0);
            $('#4250Count').text(data.l4250_count ?? 0);
            $('#2015Count').text(data.l2015_count ?? 0);
            $('#lx310Count').text(data.lx310_count ?? 0);
            $('#l360Count').text(data.l360_count ?? 0);
            $('#m401Count').text(data.m401_count ?? 0);
            $('#402nCount').text(data.m402_count ?? 0);
            $('#4003dnCount').text(data.l4003_count ?? 0);
            $('#hp1280Count').text(data.hp1280_count ?? 0);
            $('#otherprintersCount').text(data.other_printer_count ?? 0);
        },
        error: function(xhr, status, err) {
            console.error('AJAX error', status, err, xhr.responseText);
            $('#totalCount').text('Error');
        }
    });
}

function loadSiteCounts() {
    const region = $('#dbregionSelect').val();
    const site = $('#dbsiteSelect').val();

    $.ajax({
        url: 'dashboardv3-site-data.php',
        method: 'GET',
        data: { region: region, site: site },
        dataType: 'json',
        success: function(data) {
            // existing DOM updates
            $('#actualSiteCount').text(data.actualSite_total ?? 0);
            $('#dualServerCount').text(data.dualServer_total ?? 0);
            $('#proponentCount').text(data.proponent_count ?? 0);
            $('#governmentCount').text(data.government_total ?? 0);

            $('#roCount').text(data.ro_count ?? 0);
            $('#nruCount').text(data.nru_count ?? 0);
            $('#lcCount').text(data.lc_count ?? 0);
            $('#maidrsCount').text(data.maidrs_count ?? 0);
            $('#doCount').text(data.do_count ?? 0);
            $('#dlroCount').text(data.dlro_count ?? 0);
            $('#eoCount').text(data.eo_count ?? 0);
            $('#epatCount').text(data.epat_count ?? 0);
            $('#opdCount').text(data.opd_count ?? 0);

            $('#mvCount').text(data.mv_count ?? 0);
            $('#mvnewCount').text(data.mvnew_count ?? 0);
            $('#dlCount').text(data.dl_count ?? 0);
            $('#dlnewCount').text(data.dlnew_count ?? 0);
            $('#letasCount').text(data.letas_count ?? 0);
            $('#maidrstxCount').text(data.maidrstx_count ?? 0);

            $('#mvtxCount').text(data.mvtx_count ?? 0);
            $('#mvnewtxCount').text(data.mvnewtx_count ?? 0);
            $('#dltxCount').text(data.dltx_count ?? 0);
            $('#dlnewtxCount').text(data.dlnewtx_count ?? 0);
            $('#letastxCount').text(data.letas_count ?? 0);
            $('#maidrstxtxCount').text(data.maidrstxtx_count ?? 0);

            $('#siteCount').text(data.site_total ?? 0);

            updateStatBoxColors();

            // now render the office type horizontal bar chart
            renderOfficeBarChart(data);
            renderTransactionBarChart(data); // ✅ call it here
        },
        error: function(xhr, status, err) {
            console.error('AJAX error', status, err, xhr.responseText);
            $('#siteCount').text('Error');
        }
    });
}

$(function() {
    loadFilters();
    loadDashboardCounts();
    loadSiteCounts(); // ✅ also load site counts on page load

    $('#dbregionSelect').off('change').on('change', function() {
        let regionId = $(this).val();
        loadSites(regionId);
        loadDashboardCounts();
        loadSiteCounts(); // ✅ reload site counts when region changes
    });

    $('#dbsiteSelect').off('change').on('change', function() {
        loadDashboardCounts();
        loadSiteCounts(); // ✅ reload site counts when site changes
    });

    // Auto-refresh every 5s
    setInterval(function() {
        loadDashboardCounts();
        loadSiteCounts(); // ✅ refresh site counts too
    }, 5000);
});

// Debug alerts (you can remove later)
$('#dbregionSelect').on('change', function() {
    let regionId = $(this).val();
    alert("Selected Region ID: " + (regionId || "All Regions"));
});

$('#dbsiteSelect').on('change', function() {
    let siteCode = $(this).val();
    alert("Selected Site Code: " + (siteCode || "All Sites"));
});

function toggleCards() {
    const selectedValue = $('#dbsiteSelect').val();
    if (selectedValue !== "") {
        $('#allSiteCard2').removeClass('d-none');
        $('#allSiteCard').addClass('d-none');
    } else {
        $('#allSiteCard2').addClass('d-none');
        $('#allSiteCard').removeClass('d-none');
    }
}

$(document).ready(function () {
    $('#dbsiteSelect').on('change input', function () {
        toggleCards();
    });

    toggleCards(); // Initial check
});


  //stat box update colors
  function updateStatBoxColors() {
    const txIds = [
      'mvtxCount',
      'mvnewtxCount',
      'dltxCount',
      'dlnewtxCount',
      'letastxCount',
      'maidrstxtxCount'
    ];

    txIds.forEach(function(id) {
      const $p = $('#' + id);
      const valueText = $p.text().trim();
      const value = parseInt(valueText, 10);

      const $statBox = $p.closest('.stat-box');

      if (!isNaN(value)) {
        // Remove old colors first
        $statBox.removeClass('green-bg red-bg');

        if (value === 0) {
          $statBox.addClass('red-bg');
        } else if (value === 1) {
          $statBox.addClass('green-bg');
        }
      }
    });
  }

  // Run on page load
  $(document).ready(function () {
    updateStatBoxColors();
  });

    function renderOfficeBarChart(data) {
        const ctx = document.getElementById('officeBarChart').getContext('2d');

        // Wrap labels if too long
        const labels = [
            'Regional Office',
            'District Office',
            'Licensing Center',
            'Extension Office',
            'New Registration Unit',
            'MAIDRS',
            'EPATROL',
            'DLRO'
        ].map(label => {
            const maxLen = 12;
            if (label.length > maxLen) {
                const words = label.split(' ');
                let line = '', lines = [];
                words.forEach(word => {
                    if ((line + word).length > maxLen) {
                        if (line) lines.push(line.trim());
                        line = word + ' ';
                    } else {
                        line += word + ' ';
                    }
                });
                if (line) lines.push(line.trim());
                return lines.join('\n'); // Join wrapped lines with newline
            } else {
                return label;
            }
        });

        const dataValues = [
            data.ro_count ?? 0,
            data.do_count ?? 0,
            data.lc_count ?? 0,
            data.eo_count ?? 0,
            data.nru_count ?? 0,
            data.maidrs_count ?? 0,
            data.epat_count ?? 0,
            data.dlro_count ?? 0
        ];

        if (window.officeChartInstance) window.officeChartInstance.destroy();

        window.officeChartInstance = new Chart(ctx, {
            type: 'horizontalBar', // <-- horizontal bars
            data: {
                labels: labels,
                datasets: [{
                    label: 'Office Counts',
                    data: dataValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false, // disables animation (good for auto-refresh)
                scales: {
                    xAxes: [{
                        ticks: { beginAtZero: true, precision: 0 }
                    }],
                    yAxes: [{
                        ticks: { autoSkip: false }
                    }]
                },
                legend: { display: false }
            },
            plugins: [{
                afterDatasetsDraw: function(chart) {
                    const ctx = chart.ctx;
                    ctx.font = 'bold 12px Arial';
                    ctx.textAlign = 'left';
                    ctx.textBaseline = 'middle';

                    chart.data.datasets.forEach(function(dataset, i) {
                        const meta = chart.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            const value = dataset.data[index];
                            if (value > 0) {
                                ctx.fillText(value, bar._model.x + 5, bar._model.y); // number on the right of the bar
                            }
                        });
                    });
                }
            }]
        });
    }

    function renderTransactionBarChart(data) {
        const ctx = document.getElementById('transactionBarChart').getContext('2d');

        const labels = ['MV Transactions','MV New','DL Transaction','DL New','LETAS','MAIDRS'];
        const dataValues = [
            data.mv_count ?? 0,
            data.mvnew_count ?? 0,
            data.dl_count ?? 0,
            data.dlnew_count ?? 0,
            data.letas_count ?? 0,
            data.maidrstx_count ?? 0
        ];

        if (window.transactionChartInstance) window.transactionChartInstance.destroy();

        window.transactionChartInstance = new Chart(ctx, {
            type: 'bar', // vertical bars
            data: {
                labels: labels,
                datasets: [{
                    label: 'Transactions',
                    data: dataValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                scales: {
                    xAxes: [{ ticks: { autoSkip: false, maxRotation: 0, minRotation: 0 } }],
                    yAxes: [{ ticks: { beginAtZero: true, precision: 0 } }]
                },
                legend: { display: false }
            },
            plugins: [{
                afterDatasetsDraw: function(chart) {
                    const ctx = chart.ctx;
                    ctx.font = 'bold 12px Arial';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    chart.data.datasets.forEach(function(dataset, i) {
                        const meta = chart.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            const value = dataset.data[index];
                            if (value > 0) {
                                ctx.fillText(value, bar._model.x, bar._model.y - 4); // same as horizontal, but bar._model.y points top
                            }
                        });
                    });
                }
            }]
        });
    }















