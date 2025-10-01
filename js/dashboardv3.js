// Load Regions (and then auto-load sites for the first region)
function loadFilters() {
    $.getJSON('dashboardv3-filters.php', { type: 'region' }, function(data) {
        let $dbregionSelect = $('#dbregionSelect');
        $dbregionSelect.empty()
                        .append('<option value="">All Regions</option>')
                        .append('<option value="LTO">LTO National</option>');
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
            // helper function to format numbers
            function formatNum(num) {
                return Number(num ?? 0).toLocaleString();
            }

            $('#serverCount').text(formatNum(data.server_count));
            $('#serverCount2').text(formatNum(data.server2_count));

            $('#serverHpCount').text(formatNum(data.server_hp_count));
            $('#serverIbmCount').text(formatNum(data.server_ibm_count));
            $('#serverXitrixCount').text(formatNum(data.server_xitrix_count));
            $('#serverDellCount').text(formatNum(data.server_dell_count));
            $('#serverLenovoCount').text(formatNum(data.server_lenovo_count));
            $('#VMServerCount').text(formatNum(data.vm_server_count));

            $('#cpuPcCount').text(formatNum(data.cpu_pc_count));
            $('#xpCount').text(formatNum(data.xp_count));
            $('#w1032bitCount').text(formatNum(data.w1032bit_count));
            $('#w1064bitCount').text(formatNum(data.w1064bit_count));
            $('#w11Count').text(formatNum(data.w11_count));

            $('#monitorCount').text(formatNum(data.monitor_count));
            $('#keyboardCount').text(formatNum(data.keybpard_count));
            $('#mouseCount').text(formatNum(data.mouse_count));
            $('#webcamCount').text(formatNum(data.webcam_count));
            $('#sigpadCount').text(formatNum(data.sigpad_count));
            $('#scannerCount').text(formatNum(data.scanner_count));
            $('#posCount').text(formatNum(data.pos_count));
            $('#LCDDisplayCount').text(formatNum(data.LCD_Display_count));
            $('#cashDrawerCount').text(formatNum(data.cash_drawer_count));
            $('#totalCount').text(formatNum(data.total_count));

            $('#rsuCount').text(formatNum(data.rsu_count));
            $('#mvdtoCount').text(formatNum(data.mvdto_count));
            $('#mvmaintCount').text(formatNum(data.mvmaint_count));
            $('#imsaiuCount').text(formatNum(data.imsaiu_count));
            $('#dldtoCount').text(formatNum(data.dldto_count));
            $('#dlmaintCount').text(formatNum(data.dlmaint_count));

            $('#switchCount').text(formatNum(data.switch_count));
            $('#sdwanCount').text(formatNum(data.sdwan_count));
            $('#routerCount').text(formatNum(data.router_count));
            $('#modemCount').text(formatNum(data.modem_count));
            $('#dataCabCount').text(formatNum(data.dataCabCount_count));

            $('#laserjetCount').text(formatNum(data.laserjet_count));
            $('#dotmatrixCount').text(formatNum(data.dotmatrix_count));
            $('#inkjetCount').text(formatNum(data.inkjet_count));
            $('#deskjetCount').text(formatNum(data.deskjet_count));

            $('#tableCount').text(formatNum(data.table_count));
            $('#chairCount').text(formatNum(data.chair_count));
            $('#drawerCount').text(formatNum(data.drawer_count));

            $('#printerCount').text(formatNum(data.printer_count));

            $('#4100Count').text(formatNum(data.l4100_count));
            $('#507Count').text(formatNum(data.l507_count));
            $('#lx300Count').text(formatNum(data.lx300_count));
            $('#l310Count').text(formatNum(data.l310_count));
            $('#4250Count').text(formatNum(data.l4250_count));
            $('#2015Count').text(formatNum(data.l2015_count));
            $('#lx310Count').text(formatNum(data.lx310_count));
            $('#l360Count').text(formatNum(data.l360_count));
            $('#m401Count').text(formatNum(data.m401_count));
            $('#402nCount').text(formatNum(data.m402_count));
            $('#4003dnCount').text(formatNum(data.l4003_count));
            $('#hp1280Count').text(formatNum(data.hp1280_count));

            $('#otherprintersCount').text(formatNum(data.other_printer_count));
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

            $('#nodeCount').text(data.nd_count ?? 0);
            $('#ndWorking').text(data.ndWorking_count ?? 0);
            $('#ndAvailable').text(data.ndAvailable_count ?? 0);
            $('#ndDefective').text(data.ndDefective_count ?? 0);

            $('#outlet').text(data.outlet_count ?? 0);
            $('#outletWorking').text(data.outletWorking_count ?? 0);
            $('#outletAvailable').text(data.outletAvailable_count ?? 0);
            $('#outletDefective').text(data.outletDefective_count ?? 0);

            $('#portCount').text(data.port_count ?? 0);
            $('#portWorking').text(data.portWorking_count ?? 0);
            $('#portAvailable').text(data.portAvailable_count ?? 0);
            $('#portDefective').text(data.portDefective_count ?? 0);

            $('#fxdSharing').text(data.fxdSharing_count ?? 0);
            $('#seprateMeter').text(data.seprateMeter_count ?? 0);
            $('#noCost').text(data.noCost_count ?? 0);

            $('#siteCount').text(data.site_total ?? 0);

            updateStatBoxColors();

            // now render the office type horizontal bar chart
            renderOfficeBarChart(data);
            renderTransactionBarChart(data); // call it here
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
    loadSiteCounts(); // also load site counts on page load

    $('#dbregionSelect').off('change').on('change', function() {
        let regionId = $(this).val();
        loadSites(regionId);
        loadDashboardCounts();
        loadSiteCounts(); // reload site counts when region changes
    });

    $('#dbsiteSelect').off('change').on('change', function() {
        loadDashboardCounts();
        loadSiteCounts(); // reload site counts when site changes
    });

    // Auto-refresh every 5s
    setInterval(function() {
        loadDashboardCounts();
        loadSiteCounts(); // refresh site counts too
    }, 5000);
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
            'LRS',
            //'MAIDRS',
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
            data.lrs_count ?? 0,
            //data.maidrs_count ?? 0,
            
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


















