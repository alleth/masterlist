// Back to Top Button Functionality
document.addEventListener('DOMContentLoaded', () => {
    const backToTopButton = document.getElementById('backToTop');

    // Show/hide button based on scroll position
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });

    // Smooth scroll to top on click
    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
// Dynamically adjust main-content margin based on filter width
function adjustMainContentMargin() {
    const filter = document.querySelector('.filter-fixed');
    const mainContent = document.querySelector('.main-content');
    if (window.innerWidth >= 768) {
        const filterWidth = filter.offsetWidth;
        const containerPadding = 2 * 16; // 1rem = 16px, both sides
        const gutter = -10; // Bootstrap full gutter
        mainContent.style.marginRight = `${filterWidth + containerPadding + gutter}px`;
        mainContent.style.maxWidth = `calc(100% - ${filterWidth + containerPadding + gutter}px)`;
    } else {
        mainContent.style.marginRight = '0';
        mainContent.style.maxWidth = '100%';
    }
}

// Run on load and resize
window.addEventListener('load', adjustMainContentMargin);
window.addEventListener('resize', adjustMainContentMargin);

document.addEventListener('DOMContentLoaded', function() {
    console.log('Loading dashboard');
    showSpinners();
    fetchRegions();
    fetchSiteCounts({});
    const regionFilter = document.getElementById('regionSelect');
    const siteFilter = document.getElementById('siteSelect');

    if (!regionFilter || !siteFilter) {
        console.error('Error: regionSelect or siteSelect not found');
        alert('Dashboard initialization failed');
        hideSpinners();
        return;
    }

    regionFilter.addEventListener('change', function() {
        const regionId = this.value;
        console.log('Region changed to:', regionId);
        siteFilter.innerHTML = '<option value="0">All Sites</option>';
        siteFilter.disabled = !regionId;
        if (regionId) {
            fetchSites(regionId);
        }
        fetchHardwareData({ region_id: regionId });
        fetchSiteCounts({ region_id: regionId });
    });

    siteFilter.addEventListener('change', function() {
        const regionId = regionFilter.value;
        const siteCode = this.value;
        console.log('Site changed to:', siteCode);
        fetchHardwareData({ region_id: regionId, site_code: siteCode });
        fetchSiteCounts({ region_id: regionId, site_code: siteCode });
    });
});

function fetchRegions() {
    console.log('Fetching regions via jQuery');
    $.ajax({
        url: 'http://localhost/masterlist/api.php',
        method: 'GET',
        data: { action: 'getRegions' },
        dataType: 'json',
        success: function(regions) {
            console.log('Regions data:', regions);
            if (regions.error) {
                console.error('API error:', regions.error);
                alert('Failed to load regions: ' + regions.error);
                hideSpinners();
                return;
            }
            const regionFilter = document.getElementById('regionSelect');
            regionFilter.innerHTML = '<option value="">All Regions</option>';
            regions.forEach(region => {
                regionFilter.innerHTML += `<option value="${region.region_id}">${region.region_name}</option>`;
            });
            fetchHardwareData({});
        },
        error: function(xhr, status, error) {
            console.error('Error fetching regions:', status, error);
            alert('Error fetching regions: ' + (xhr.statusText || error));
            hideSpinners();
        }
    });
}

function fetchSites(regionId) {
    console.log('Fetching sites for region:', regionId);
    $.ajax({
        url: 'http://localhost/masterlist/api.php',
        method: 'GET',
        data: { action: 'getSites', region_id: regionId },
        dataType: 'json',
        success: function(sites) {
            console.log('Sites data:', sites);
            if (sites.error) {
                console.error('Sites error:', sites.error);
                alert('Failed to load sites: ' + sites.error);
                return;
            }
            const siteFilter = document.getElementById('siteSelect');
            siteFilter.innerHTML = '<option value="0">All Sites</option>';
            sites.forEach(site => {
                siteFilter.innerHTML += `<option value="${site.site_code}">${site.site_code} - ${site.site_name}</option>`;
            });
            siteFilter.disabled = false;
        },
        error: function(xhr, status, error) {
            console.error('Error fetching sites:', status, error);
            alert('Error fetching sites: ' + (xhr.statusText || error));
        }
    });
}

function fetchHardwareData(params) {
    console.log('Fetching hardware data with params:', params);
    showSpinners();
    const data = Object.assign({ action: 'getHardwareCounts' }, params);
    $.ajax({
        url: 'http://localhost/masterlist/api.php',
        method: 'GET',
        data: data,
        dataType: 'json',
        success: function(data) {
            console.log('Received hardware data:', data);
            if (data.error) {
                console.error('API error:', data.error);
                alert('Error fetching hardware: ' + data.error);
                hideSpinners();
                return;
            }
            updateHardwareAccordion(data);
            hideSpinners();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching hardware:', status, error);
            alert('Error fetching hardware: ' + (xhr.statusText || error));
            hideSpinners();
        }
    });
}

function updateHardwareData() {
    console.error('Error fetching hardwareData');
}

function fetchSiteCounts(params) {
    console.log('Fetching site counts with params:', params);
    $.ajax({
        url: 'http://localhost/masterlist/api.php',
        method: 'GET',
        data: Object.assign({ action: 'getSiteCounts' }, params),
        dataType: 'json',
        success: function(data) {
            console.log('Received site counts:', data);
            if (data.error) {
                console.error('API error:', data.error);
                alert('Error fetching site counts: ' + data.error);
                return;
            }
            updateSiteCard(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching site counts:', error);
            alert('Error fetching site counts: ' + error);
        }
    });
}

function updateSiteCard(data) {
    const cardBody = document.querySelector('.counts-card .card-body .row');
    if (!cardBody) {
        console.error('Error: Counts card body not found');
        return;
    }

    if (data.office_type) {
        cardBody.innerHTML = `
            <div class="col-12">
                <label class="form-label text-muted">Office Type</label>
                <h6 class="text-dark">${data.office_type}</h6>
            </div>
            <div class="col-12">
                <label class="form-label text-muted">Ownership</label>
                <h6 class="text-dark">${data.site_partnership}</h6>
            </div>
            
            <div class="col-12">
                <label class="form-label text-muted">Transaction Catered</label>
                <h6 class="text-dark">${data.trxn_catered}</h6>
            </div>
            
            <div class="col-12">
                <label class="form-label text-muted">Type of Electrical Connection</label>
                <h6 class="text-dark">Display type of electrical connection here.</h6>
            </div>
        `;
    } else {
        cardBody.innerHTML = `
            <div class="col-12">
                <h3 class="text-dark">${data.total_sites.toLocaleString('en-US')}</h3>
                <label class="form-label text-muted">Total Number of Sites</label>
            </div>
            <div class="col-12">
                <h3 class="text-dark">${data.proponent_count.toLocaleString('en-US')}</h3>
                <label class="form-label text-muted">Proponent-Owned</label>
            </div>
            <div class="col-12">
                <h3 class="text-dark">${data.government_count.toLocaleString('en-US')}</h3>
                <label class="form-label text-muted">Government-Owned</label>
            </div>
        `;
    }
}

function showSpinners() {
    const accordion = document.getElementById('hardwareAccordion');
    if (accordion) {
        accordion.innerHTML = '<div class="spinner-container d-flex justify-content-center align-items-center"><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    }
}

function hideSpinners() {
    // Handled by updateHardwareAccordion
}

function updateHardwareAccordion(data) {
    const textUnidentified = '<b class="text-danger">Unidentified</b>';
    const accordion = document.getElementById('hardwareAccordion');
    if (!accordion) {
        console.error('Error: hardware element not found');
        return;
    }

    // Debug: Log printers data to verify content
    console.log('Printers data:', JSON.stringify(data.printers, null, 2));

    accordion.innerHTML = '';
    if (!data.total && !data.servers?.total && !data.workstations?.total && !data.printers?.total && !data.peripherals?.total && !data.network_equipment?.total && !data.ups?.total) {
        accordion.innerHTML = '<div class="text-center text-muted">No hardware data available</div>';
        return;
    }

    const categories = [
        {
            name: 'Servers',
            id: 'servers',
            total: data.servers?.total || 0,
            brands: (data.servers?.brands || []).flatMap(item =>
                (item.models || []).map(model => ({
                    brand: item.brand || textUnidentified,
                    model: model.model || textUnidentified,
                    count: model.count
                }))
            ),
            os: (data.servers?.os || []).map(item => ({
                name: item.name || textUnidentified,
                count: item.count
            }))
        },
        {
            name: 'CPU-PC',
            id: 'workstations',
            total: data.workstations?.total || 0,
            os: (data.workstations?.os || []).map(item => ({
                name: item.name || textUnidentified,
                count: item.count
            })),
            brands: (data.workstations?.brands || []).flatMap(item =>
                (item.models || []).map(model => ({
                    brand: item.brand || textUnidentified,
                    model: model.model || textUnidentified,
                    count: model.count
                }))
            )
        },
        {
            name: 'Printers',
            id: 'printers',
            total: data.printers?.total || 0,
            printer_types: (data.printers?.printer_types || []).map(type => ({
                name: type.name || textUnidentified,
                count: type.count || 0
            }))
        },
        {
            name: 'Network Equipment',
            id: 'network_equipment',
            total: data.network_equipment?.total || 0,
            subcategories: (data.network_equipment?.categories || []).map(category => ({
                name: category.name || textUnidentified,
                items: (category.items || []).map(item => ({
                    brand: item.brand || textUnidentified,
                    model: item.model || textUnidentified,
                    count: item.count
                }))
            }))
        },
        {
            name: 'Uninterruptible Power Supply - UPS',
            id: 'ups',
            total: data.ups?.total || 0,
            subcategories: (data.ups?.categories || []).map(category => ({
                name: category.name || textUnidentified,
                items: (category.items || []).map(item => ({
                    brand: item.brand || textUnidentified,
                    model: item.model || textUnidentified,
                    count: item.count
                }))
            }))
        },
        {
            name: 'Peripherals',
            id: 'peripherals',
            total: data.peripherals?.total || 0,
            items: [
                ...(data.peripherals?.categories || []).map(item => ({
                    description: `${item.name || textUnidentified}`,
                    count: item.items?.reduce((sum, i) => sum + i.count, 0) || 0
                }))
            ]
        }
    ];

    categories.forEach(category => {
        const hasBrands = category.brands?.length > 0 && category.total > 0;
        const hasOS = category.os?.length > 0;
        const hasTypes = category.printer_types?.length > 0 && category.total > 0;
        const validSubcategories = category.subcategories?.filter(sub => sub.items?.length > 0) || [];
        const hasSubcategories = validSubcategories.length > 0 && category.total > 0;
        const hasItems = category.items?.length > 0;

        // Display category if it has a non-zero total, brands, OS, subcategories, items, or printer types
        if (category.total === 0 && !hasBrands && !hasOS && !hasSubcategories && !hasItems && !(category.id === 'printers' && hasTypes)) return;

        let tableContent = '';
        if (hasBrands && category.id !== 'printers') {
            tableContent += `
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Model</th>
                            <th class="count-column">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${category.brands.map(item => `
                            <tr>
                                <td>${item.brand}</td>
                                <td>${item.model}</td>
                                <td class="count-column">${(item.count || 0).toLocaleString('en-US')}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        } else if (category.id === 'printers') {
            // Always show printers table, even if only total is available
            tableContent += `
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Printer Type</th>
                            <th class="count-column">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${hasTypes ? category.printer_types.map(item => `
                            <tr>
                                <td>${item.name}</td>
                                <td class="count-column">${(item.count || 0).toLocaleString('en-US')}</td>
                            </tr>
                        `).join('') : `
                            <tr>
                                <td>Total Printers</td>
                                <td class="count-column">${category.total.toLocaleString('en-US')}</td>
                            </tr>
                        `}
                    </tbody>
                </table>
            `;
        } else if (hasSubcategories) {
            validSubcategories.forEach(sub => {
                tableContent += `
                    <h5>${sub.name}</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Model</th>
                                <th class="count-column">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${sub.items.map(item => `
                                <tr>
                                    <td>${item.brand}</td>
                                    <td>${item.model}</td>
                                    <td class="count-column">${item.count.toLocaleString('en-US')}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
            });
        } else if (category.id === 'peripherals') {
            // Always show peripherals table, even if only total is available
            tableContent += `
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th class="count-column">Total Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${hasItems ? category.items.map(item => `
                            <tr>
                                <td>${item.description}</td>
                                <td class="count-column">${item.count.toLocaleString('en-US')}</td>
                            </tr>
                        `).join('') : `
                            <tr>
                                <td>Total Peripherals</td>
                                <td class="count-column">${category.total.toLocaleString('en-US')}</td>
                            </tr>
                        `}
                    </tbody>
                </table>
            `;
        }

        let OSTableContent = '';
        if (hasOS) {
            OSTableContent = `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Operating System Version</th>
                            <th class="count-column">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${category.os.map(item => `
                            <tr>
                                <td>${item.name}</td>
                                <td class="count-column">${item.count.toLocaleString('en-US')}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        }

        if (tableContent || OSTableContent) {
            accordion.innerHTML += `
                <div class="accordion-item">
                    <h2 class="accordion-header" id="${category.id}-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${category.id}-collapse" aria-controls="${category.id}-collapse">
                            ${category.name} (${category.total.toLocaleString('en-US')})
                        </button>
                    </h2>
                    <div id="${category.id}-collapse" class="accordion-collapse collapse" aria-labelledby="${category.id}-header" data-bs-parent="#hardwareAccordion">
                        <div class="accordion-body">
                            ${category.id === 'workstations' ? OSTableContent : tableContent}
                            ${category.id === 'workstations' ? tableContent : OSTableContent}
                        </div>
                    </div>
                </div>
            `;
        }
    });
}