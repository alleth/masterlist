$(document).ready(function() {

    // Object to track assigned utilities (utility -> hw_asset_num)
    let assignedUtilities = {};
    // Object to track assigned worksteps (workstep -> hw_asset_num)
    let assignedWorksteps = {};

    // Initialize Select2 if a .utilitiesSelect already exists on page load
    $(".utilitiesSelect").each(function () {
        $(this).select2({
            placeholder: "Select Utilities",
            allowClear: true,
            closeOnSelect: false,
            width: '100%',
            theme: 'bootstrap-5'
        });
    });

    // Format MAC Address (e.g., 001122334455 -> 00-11-22-33-44-55)
    function formatMacAddress(value) {
        let cleaned = value.replace(/[^0-9A-Fa-f]/g, '').substring(0, 12);
        let formatted = '';
        for (let i = 0; i < cleaned.length; i++) {
            if (i > 0 && i % 2 === 0 && i < 12) {
                formatted += '-';
            }
            formatted += cleaned[i].toUpperCase();
        }
        return formatted;
    }

    // Validate MAC Address (12 hexadecimal characters)
    function isValidMacAddress(value) {
        const cleaned = value.replace(/[^0-9A-Fa-f]/g, '');
        return /^[0-9A-Fa-f]{12}$/.test(cleaned);
    }

    // Format IP Address (Windows-like: fixed dots, default 0.0.0.0, empty octets as 0)
    function formatIpAddress(value) {
        // Return default if empty or undefined
        if (!value || value.trim() === '') {
            return '0.0.0.0';
        }
        // Remove invalid characters, keep digits and dots
        let cleaned = value.replace(/[^0-9.]/g, '');
        // Split into octets, remove empty parts
        let parts = cleaned.split('.').filter(part => part !== '');
        // Limit to 4 octets, trim to max 3 digits per octet, use '0' for empty octets
        parts = parts.slice(0, 4).map(part => part.length > 0 ? part.substring(0, 3) : '0');
        // Pad with '0' if fewer than 4 octets
        while (parts.length < 4) {
            parts.push('0');
        }
        // Join with fixed dots
        return parts.join('.');
    }

    // Validate IP Address (four octets, 0-255 each)
    function isValidIpAddress(value) {
        const parts = value.split('.');
        if (parts.length !== 4) return false;
        return parts.every(part => {
            const num = parseInt(part, 10);
            return !isNaN(num) && num >= 0 && num <= 255 && part.match(/^\d{1,3}$/);
        });
    }

    // Show error toast with a user-friendly message
    function showErrorToast(message) {
        const toastEl = document.getElementById('toastInvalidInput');
        $('#invalidInputMessage').text(message);
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    // Load regions on page load
    $.ajax({
        url: 'software-config-api.php',
        type: 'POST',
        data: { action: 'getRegions' },
        dataType: 'json',
        timeout: 10000, // 10-second timeout
        success: function(response) {
            if (response.success) {
                let regionSelect = $('#CpuPCRegionSelect');
                regionSelect.empty().append('<option value="" disabled selected>Select Region</option>');
                response.data.forEach(function(region) {
                    regionSelect.append(`<option value="${region.region_id}">${region.region_name}</option>`);
});
} else {
    showErrorToast('Failed to load regions: ' + response.message);
    console.error('Error fetching regions:', response.message);
}
},
error: function(xhr, status, error) {
    let message = 'Failed to load regions. Please try again later.';
    if (status === 'timeout') {
        message = 'Server took too long to respond. Please check your connection and try again.';
    } else if (xhr.status === 0) {
        message = 'Unable to connect to the server. Please check your network.';
    }
    showErrorToast(message);
    console.error('AJAX error (getRegions):', status, error, xhr.responseText);
}
});

// Handle region selection change
$('#CpuPCRegionSelect').change(function() {
    let regionId = $(this).val();
    let siteSelect = $('#CpuPCSiteSelect');

    // Reset site dropdown
    siteSelect.empty().append('<option value="" disabled>Select Site</option>');

    if (!regionId) {
        siteSelect.prop('disabled', true);
        return;
    }

    // Enable site select and fetch sites for selected region
    siteSelect.prop('disabled', false);

    $.ajax({
        url: 'software-config-api.php',
        type: 'POST',
        data: {
            action: 'getSitesByRegion',
            region_id: regionId
        },
        dataType: 'json',
        timeout: 10000, // 10-second timeout
        success: function(response) {
            if (response.success) {
                response.data.forEach(function(site) {
                    siteSelect.append(
                        `<option value="${site.site_code}">${site.site_code} – ${site.site_name}</option>`
                    );
                });
            } else {
                showErrorToast('Failed to load sites: ' + response.message);
                console.error('Error fetching sites:', response.message);
            }
        },
        error: function(xhr, status, error) {
            let message = 'Failed to load sites. Please try again later.';
            if (status === 'timeout') {
                message = 'Server took too long to respond. Please check your connection and try again.';
            } else if (xhr.status === 0) {
                message = 'Unable to connect to the server. Please check your network.';
            }
            showErrorToast(message);
            console.error('AJAX error (getSitesByRegion):', status, error, xhr.responseText);
        }
    });
});

// Update utilities dropdowns for all accordion items except the current one
function updateUtilitiesDropdowns(currentAssetNum, currentUtilities) {
    $('#accordionExample .accordion-item').each(function() {
        const $accordionItem = $(this);
        const assetNum = $accordionItem.data('asset-num');
        if (assetNum === currentAssetNum) return; // Skip the current accordion item

        const $utilSelect = $accordionItem.find('select[name="utilities[]"]');
        const selectedUtilities = $utilSelect.val() || [];

        // Define all possible utilities
        const allUtilities = [
            { value: 'RSU Facility', text: 'RSU Facility' },
            { value: 'MV DTO', text: 'MV DTO' },
            { value: 'MV Maintenance', text: 'MV Maintenance' },
            { value: 'IMS-AIU', text: 'IMS-AIU' },
            { value: 'DL DTO', text: 'DL DTO' },
            { value: 'DL Manint', text: 'DL Manint' }
        ];

        // Filter out utilities assigned to other CPU-PCs
        const availableUtilities = allUtilities.filter(function(utility) {
            return !assignedUtilities[utility.value] ||
                assignedUtilities[utility.value] === assetNum ||
                selectedUtilities.includes(utility.value);
        });

        // Rebuild the dropdown
        $utilSelect.empty();
        availableUtilities.forEach(function(utility) {
            $utilSelect.append(`<option value="${utility.value}">${utility.text}</option>`);
        });

        // Restore selected utilities
        $utilSelect.val(selectedUtilities).trigger('change.select2');
    });
}

// Update workstep dropdowns for all accordion items except the current one
function updateWorkstepDropdowns(currentAssetNum, currentWorkstep) {
    $('#accordionExample .accordion-item').each(function() {
        const $accordionItem = $(this);
        const assetNum = $accordionItem.data('asset-num');
        if (assetNum === currentAssetNum) return; // Skip the current accordion item

        const $workstepSelect = $accordionItem.find('select[name="hw_primary_role"]');
        const selectedWorkstep = $workstepSelect.val() || '';

        // Define all possible worksteps
        const allWorksteps = [
            { value: 'Evaluator', text: 'Evaluator' },
            { value: 'PhotoSig', text: 'PhotoSig' },
            { value: 'Approving', text: 'Approving' },
            { value: 'Cashier', text: 'Cashier' },
            { value: 'Releasing', text: 'Releasing' }
        ];

        // Filter out worksteps assigned to other CPU-PCs (only for Approving)
        const availableWorksteps = allWorksteps.filter(function(workstep) {
            return workstep.value !== 'Approving' ||
                !assignedWorksteps['Approving'] ||
                assignedWorksteps['Approving'] === assetNum ||
                selectedWorkstep === 'Approving';
        });

        // Rebuild the dropdown
        $workstepSelect.empty();
        $workstepSelect.append('<option selected disabled>Select Workstep</option>');
        availableWorksteps.forEach(function(workstep) {
            $workstepSelect.append(`<option value="${workstep.value}">${workstep.text}</option>`);
        });

        // Restore selected workstep
        $workstepSelect.val(selectedWorkstep || '');
    });
}

// Handle show button click
$('#showCPUPCButton').click(function() {
    let regionId = $('#CpuPCRegionSelect').val();
    let siteCode = $('#CpuPCSiteSelect').val();

    if (!regionId || !siteCode) {
        let toastEl = document.getElementById('toastValidation');
        let toast = new bootstrap.Toast(toastEl);
        toast.show();
        return;
    }

    // Reset assigned utilities and worksteps on new fetch
    assignedUtilities = {};
    assignedWorksteps = {};

    $.ajax({
        url: 'software-config-api.php',
        type: 'POST',
        data: {
            action: 'getHardware',
            region_id: regionId,
            site_code: siteCode
        },
        dataType: 'json',
        timeout: 10000, // 10-second timeout
        beforeSend: function() {
            var showHwButton = document.getElementById('showCPUPCButton');
            if (showHwButton) {
                showHwButton.disabled = true;
            }

            $("#accordionExample").empty(); // Clear existing content
            $("#accordionExample").html(`
                    <div class='text-center'>
                        <div class='spinner-grow spinner-grow-sm text-primary' role='status'>
                            <span class='sr-only'>Loading...</span>
                        </div>
                        <div class='spinner-grow spinner-grow-sm text-primary'></div>
                        <div class='spinner-grow spinner-grow-sm text-primary'></div>
                    </div>
                `);
        },
        success: function(response) {
            var showHwButton = document.getElementById('showCPUPCButton');
            if (showHwButton) {
                showHwButton.disabled = false;
            }
            if (response.success) {
                let accordion = $('#accordionExample');
                accordion.empty();

                if (response.data.length === 0) {
                    accordion.html('<p class="text-muted text-center fst-italic">No hardware found.</p>');
                    return;
                }

                console.log('Hardware data:', response.data); // Debug: Log API response

                response.data.forEach(function(hw, index) {
                    // Check for missing details (exclude users and utilities unless Approving)
                    const hasMissingDetails = !hw.hw_host_name || !hw.hw_mac_add || !hw.hw_ip_add ||
                        hw.hw_ip_add === '0.0.0.0' || !hw.os_type || !hw.dotnet || !hw.hw_primary_role ||
                        !hw.hw_memory || !hw.hdd_capacity || !hw.hdd_free_space ||
                        (hw.hw_primary_role === 'Approving' && (!hw.utilities || hw.utilities.length === 0));

                    // Add has-warning class and set icon based on missing details
                    const warningClass = hasMissingDetails ? 'has-warning' : '';
                    const iconClass = hasMissingDetails ? 'bi-exclamation-triangle' : 'bi-pc-display';

                    // Set default IP to 0.0.0.0 if empty
                    const ipValue = hw.hw_ip_add ? formatIpAddress(hw.hw_ip_add) : '0.0.0.0';

                    // Initialize utilities for this CPU-PC
                    const utilities = hw.utilities || [];
                    utilities.forEach(function(utility) {
                        assignedUtilities[utility] = hw.hw_asset_num;
                    });

                    // Initialize workstep for this CPU-PC
                    const workstep = hw.hw_primary_role || '';
                    if (workstep === 'Approving') {
                        assignedWorksteps['Approving'] = hw.hw_asset_num;
                    }

                    let accordionItem = `
                        <div class="accordion-item ${warningClass}" data-asset-num="${hw.hw_asset_num}" data-serial-num="${hw.hw_serial_num}">
                            <h2 class="accordion-header" id="heading${index}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                                    <span class="bi ${iconClass}"></span>&nbsp; <strong>${hw.hw_model} : </strong> &nbsp; ${hw.hw_asset_num} | ${hw.hw_serial_num}
                                </button>
                            </h2>
                            <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form class="pe-form">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Hostname</label>
                                                <input type="text" class="form-control" name="hostname" value="${hw.hw_host_name || ''}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">MAC Address</label>
                                                <input type="text" class="form-control mac-address" name="mac" value="${hw.hw_mac_add || ''}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">IP Address</label>
                                                <input type="text" class="form-control ip-address" name="ip" value="${ipValue}" placeholder="0.0.0.0">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">OS Version</label>
                                                <select class="form-select" name="os">
                                                    <option value="" ${!hw.os_type ? 'selected' : ''}>Select OS Version</option>
                                                    <option value="Windows XP" ${hw.os_type === 'Windows XP' ? 'selected' : ''}>Windows XP</option>
                                                    <option value="Windows 10 32Bit" ${hw.os_type === 'Windows 10 32Bit' ? 'selected' : ''}>Windows 10 32Bit</option>
                                                    <option value="Windows 10 64Bit" ${hw.os_type === 'Windows 10 64Bit' ? 'selected' : ''}>Windows 10 64Bit</option>
                                                    <option value="Windows 11 64Bit" ${hw.os_type === 'Windows 11 64Bit' ? 'selected' : ''}>Windows 11</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">.NET Framework Version</label>
                                                <select class="form-select" name="dotnet">
                                                    <option value="" ${!hw.dotnet ? 'selected' : ''}>Select Framework Version</option>
                                                    <option value="4.0" ${hw.dotnet === '4.0' ? 'selected' : ''}>4.0</option>
                                                    <option value="4.5" ${hw.dotnet === '4.5' ? 'selected' : ''}>4.5</option>
                                                    <option value="4.7" ${hw.dotnet === '4.7' ? 'selected' : ''}>4.7</option>
                                                    <option value="4.8" ${hw.dotnet === '4.8' ? 'selected' : ''}>4.8</option>
                                                    <option value="5.0" ${hw.dotnet === '5.0' ? 'selected' : ''}>5.0</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Users</label>
                                                <select class="form-select" name="users">
                                                    <option value="" ${!hw.users ? 'selected' : ''}>Select Assigned User</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Workstep</label>
                                                <select class="form-select" name="hw_primary_role">
                                                    <option value="" ${!hw.hw_primary_role ? 'selected' : ''}>Select Workstep</option>
                                                    <option value="Evaluator" ${hw.hw_primary_role === 'Evaluator' ? 'selected' : ''}>Evaluator</option>
                                                    <option value="PhotoSig" ${hw.hw_primary_role === 'PhotoSig' ? 'selected' : ''}>PhotoSig</option>
                                                    <option value="Approving" ${hw.hw_primary_role === 'Approving' ? 'selected' : ''}>Approving</option>
                                                    <option value="Cashier" ${hw.hw_primary_role === 'Cashier' ? 'selected' : ''}>Cashier</option>
                                                    <option value="Releasing" ${hw.hw_primary_role === 'Releasing' ? 'selected' : ''}>Releasing</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Memory</label>
                                                <select class="form-select" name="hw_memory">
                                                    <option value="" ${!hw.hw_memory ? 'selected' : ''} disabled>Select Memory</option>
                                                    <option value="2GB" ${hw.hw_memory === '2GB' ? 'selected' : ''}>2GB</option>
                                                    <option value="4GB" ${hw.hw_memory === '4GB' ? 'selected' : ''}>4GB</option>
                                                    <option value="8GB" ${hw.hw_memory === '8GB' ? 'selected' : ''}>8GB</option>
                                                    <option value="16GB" ${hw.hw_memory === '16GB' ? 'selected' : ''}>16GB</option>
                                                    <option value="32GB" ${hw.hw_memory === '32GB' ? 'selected' : ''}>32GB</option>
                                                    <option value="64GB" ${hw.hw_memory === '64GB' ? 'selected' : ''}>64GB</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">HDD Capacity</label>
                                                <input type="text" class="form-control" name="hdd_capacity" value="${hw.hdd_capacity || ''}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">HDD Free Space</label>
                                                <input type="text" class="form-control" name="hdd_free_space" value="${hw.hdd_free_space || ''}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Utilities</label>
                                                <select class="form-select utilitiesSelect" id="utilitiesSelect_${index}" name="utilities[]" multiple>
                                                  <option value="RSU Facility">RSU Facility</option>
                                                  <option value="MV DTO">MV DTO</option>
                                                  <option value="MV Maintenance">MV Maintenance</option>
                                                  <option value="IMS-AIU">IMS-AIU</option>
                                                  <option value="DL DTO">DL DTO</option>
                                                  <option value="DL Manint">DL Manint</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="accordion-footer">
                                    <span class="status">Auto update</span>
                                </div>
                            </div>
                        </div>
                        `;

                    // Append the accordion item and store its jQuery object
                    const $accordionItem = $(accordionItem);
                    accordion.append($accordionItem);

                    // Initialize Select2 for THIS accordion's Utilities select
                    const $utilSel = $accordionItem.find('#utilitiesSelect_' + index);
                    $utilSel.select2({
                        placeholder: "Select Utilities",
                        allowClear: true,
                        closeOnSelect: false,
                        width: '100%',
                        theme: 'bootstrap-5',
                        dropdownParent: $utilSel.closest('.accordion-body'),
                        templateSelection: function (data) {
                            if (!data.id) return data.text;
                            return $('<span class="chip-label" style="width: 0.8rem; font-size: 0.8rem;"></span>').text(data.text);
                        },
                        templateResult: function (data) {
                            const $span = $('<span></span>').text(data.text).css({
                                'font-size': '0.8rem',
                                'line-height': '1.2'
                            });
                            return $span;
                        }
                    });

                    // Set initial utilities selection
                    $utilSel.val(utilities).trigger('change.select2');

                    // Handle utilities selection change
                    $utilSel.on('change', function() {
                        const selectedUtilities = $(this).val() || [];
                        const assetNum = $accordionItem.data('asset-num');

                        // Update assignedUtilities
                        const previouslyAssigned = $accordionItem.data('previouslyAssignedUtilities') || [];
                        previouslyAssigned.forEach(function(utility) {
                            if (!selectedUtilities.includes(utility)) {
                                delete assignedUtilities[utility];
                            }
                        });
                        selectedUtilities.forEach(function(utility) {
                            assignedUtilities[utility] = assetNum;
                        });
                        $accordionItem.data('previouslyAssignedUtilities', selectedUtilities);

                        // Update utilities dropdowns for other accordion items
                        updateUtilitiesDropdowns(assetNum, selectedUtilities);

                        // Trigger validation
                        validateAccordion($accordionItem, $utilSel);
                    });

                    // Store initial utilities for tracking
                    $accordionItem.data('previouslyAssignedUtilities', utilities);

                    // Handle workstep selection change
                    const $workstepSel = $accordionItem.find('select[name="hw_primary_role"]');
                    $workstepSel.on('change', function() {
                        const selectedWorkstep = $(this).val() || '';
                        const assetNum = $accordionItem.data('asset-num');

                        // Update assignedWorksteps
                        const previouslyAssigned = $accordionItem.data('previouslyAssignedWorkstep') || '';
                        if (previouslyAssigned === 'Approving' && selectedWorkstep !== 'Approving') {
                            delete assignedWorksteps['Approving'];
                        }
                        if (selectedWorkstep === 'Approving') {
                            assignedWorksteps['Approving'] = assetNum;
                        }
                        $accordionItem.data('previouslyAssignedWorkstep', selectedWorkstep);

                        // Update workstep dropdowns for other accordion items
                        updateWorkstepDropdowns(assetNum, selectedWorkstep);

                        // Trigger validation
                        validateAccordion($accordionItem, $workstepSel);
                    });

                    // Store initial workstep for tracking
                    $accordionItem.data('previouslyAssignedWorkstep', workstep);

                    // Attach MAC and IP formatting
                    const $macInput = $accordionItem.find('.mac-address');
                    const $ipInput = $accordionItem.find('.ip-address');

                    $macInput.on('input', function() {
                        const $this = $(this);
                        const cursorPosition = this.selectionStart;
                        const originalLength = this.value.length;
                        const formatted = formatMacAddress(this.value);
                        $this.val(formatted);

                        // Adjust cursor position
                        const newLength = formatted.length;
                        const addedChars = newLength - originalLength;
                        this.setSelectionRange(cursorPosition + addedChars, cursorPosition + addedChars);

                        // Run validation after MAC input change
                        let accordionItem = $(this).closest(".accordion-item");
                        validateAccordion(accordionItem, $this);
                    });

                    // --- helpers for IP editing ---
                    function parseIpParts(val) {
                        if (!val) return ['0', '0', '0', '0'];
                        let parts = val.replace(/[^0-9.]/g, '').split('.');
                        while (parts.length < 4) parts.push('0');
                        parts = parts.slice(0, 4).map(p => (p === '' ? '0' : p.substring(0, 3)));
                        return parts;
                    }
                    function getOctetStart(parts, idx) {
                        let pos = 0;
                        for (let i = 0; i < idx; i++) pos += parts[i].length + 1; // +1 for dot
                        return pos;
                    }
                    function setCursorPos(input, parts, idx, offset) {
                        const start = getOctetStart(parts, idx);
                        const pos = start + Math.max(0, Math.min(offset, parts[idx].length));
                        input.setSelectionRange(pos, pos);
                    }
                    function replaceRangeInOctet(oct, start, end, insert) {
                        // Treat a lone '0' as empty when editing so typing replaces it
                        const base = (oct === '0' && start === 0 && end === 1) ? '' : oct;
                        const next = (base.slice(0, start) + (insert || '') + base.slice(end)).slice(0, 3);
                        return next.length ? next : '0';
                    }

                    // --- improved IP handler ---
                    $ipInput.on('keydown input', function (e) {
                        let value = this.value.replace(/[^0-9.]/g, ''); // keep only digits & dots
                        let parts = value.split('.');

                        // Always keep 4 octets
                        while (parts.length < 4) parts.push("0");
                        parts = parts.slice(0, 4);

                        // Normalize octets (max 3 digits each, no empty strings)
                        parts = parts.map(p => p === "" ? "0" : p.substring(0, 3));

                        // Always display fixed format
                        let formatted = parts.join(".");
                        this.value = formatted;

                        const cursorPos = this.selectionStart;
                        const key = e.key;

                        // Get current octet index
                        let octetIndex = formatted.substring(0, cursorPos).split('.').length - 1;

                        // Auto move to next octet if 3 digits reached
                        if (/^[0-9]$/.test(key)) {
                            if (parts[octetIndex].length >= 3 && octetIndex < 3) {
                                let nextPos = formatted.indexOf('.', cursorPos) + 1;
                                this.setSelectionRange(nextPos, nextPos);
                            }
                        }

                        // If '.' pressed → jump to next octet
                        if (key === ".") {
                            e.preventDefault();
                            if (octetIndex < 3) {
                                let nextPos = formatted.indexOf('.', cursorPos) + 1;
                                this.setSelectionRange(nextPos, nextPos);
                            }
                        }

                        // Handle deletion without resetting whole octet
                        if (key === "Backspace" || key === "Delete") {
                            // Let normal delete happen, but ensure format stays valid
                            setTimeout(() => {
                                let v = this.value.replace(/[^0-9.]/g, '');
                                let p = v.split('.');
                                while (p.length < 4) p.push("0");
                                p = p.map(x => x === "" ? "0" : x.substring(0, 3));
                                this.value = p.slice(0, 4).join(".");
                            });
                        }

                        // Run real-time validation after every change
                        let accordionItem = $(this).closest(".accordion-item");
                        validateAccordion(accordionItem, $(this));
                    });

                    // Optional: normalize format (pad empties to '0') when leaving the field
                    $ipInput.on('blur', function () {
                        this.value = parseIpParts(this.value).join('.');
                        let accordionItem = $(this).closest(".accordion-item");
                        validateAccordion(accordionItem, $(this));
                    });

                    // Initial validation to set input warnings
                    validateAccordion($accordionItem);
                });

                // Update utilities and workstep dropdowns after all items are loaded
                $('#accordionExample .accordion-item').each(function() {
                    const $accordionItem = $(this);
                    const $utilSelect = $accordionItem.find('select[name="utilities[]"]');
                    const $workstepSelect = $accordionItem.find('select[name="hw_primary_role"]');
                    updateUtilitiesDropdowns($accordionItem.data('asset-num'), $utilSelect.val() || []);
                    updateWorkstepDropdowns($accordionItem.data('asset-num'), $workstepSelect.val() || '');
                });
            } else {
                showErrorToast('Failed to load hardware: ' + response.message);
                console.error('Error fetching hardware:', response.message);
                $("#accordionExample").html('<p class="text-muted text-center fst-italic">Failed to load hardware. Please try again.</p>');
            }
        },
        error: function(xhr, status, error) {
            var showHwButton = document.getElementById('showCPUPCButton');
            if (showHwButton) {
                showHwButton.disabled = false;
            }
            let message = 'Failed to load hardware. Please try again later.';
            if (status === 'timeout') {
                message = 'Server took too long to respond. Please check your connection and try again.';
            } else if (xhr.status === 0) {
                message = 'Unable to connect to the server. Please check your network.';
            }
            showErrorToast(message);
            console.error('AJAX error (getHardware):', status, error, xhr.responseText);
            $("#accordionExample").html('<p class="text-muted text-center fst-italic">Failed to load hardware. Please try again.</p>');
        }
    });
});

// Initialize Select2 on any .form-multi controls
$('.form-multi').each(function () {
    $(this).select2({
        placeholder: "Select options",
        closeOnSelect: false,
        width: '100%',
        dropdownParent: $(this).closest('.accordion-body'),
        templateSelection: function (data) {
            if (!data.id) return data.text;
            return $('<span class="chip-label"></span>').text(data.text);
        },
        templateResult: function (data) {
            const $span = $('<span></span>').text(data.text).css({
                'font-size': '0.8rem',
                'line-height': '1.2'
            });
            return $span;
        }
    });
});

// Real-time status and validation per accordion item
function validateAccordion($accordionItem, $changedInput = null) {
    const $form = $accordionItem.find('.pe-form');
    const $status = $accordionItem.find('.accordion-footer .status');
    const $icon = $accordionItem.find('.accordion-button .bi');

    // Get field values
    const hostname = $form.find('input[name="hostname"]').val();
    const mac = $form.find('input[name="mac"]').val();
    const ip = $form.find('input[name="ip"]').val();
    const os = $form.find('select[name="os"]').val();
    const dotnet = $form.find('select[name="dotnet"]').val();
    const workstep = $form.find('select[name="hw_primary_role"]').val();
    const memory = $form.find('select[name="hw_memory"]').val();
    const hdd_capacity = $form.find('input[name="hdd_capacity"]').val();
    const hdd_free_space = $form.find('input[name="hdd_free_space"]').val();
    const utilities = $form.find('select[name="utilities[]"]').val() || [];
    const region_id = $('#CpuPCRegionSelect').val();
    const site_code = $('#CpuPCSiteSelect').val();

    // Validate MAC and IP addresses
    let errorMessage = '';
    if (mac && !isValidMacAddress(mac)) {
        errorMessage = 'Invalid MAC Address';
        $form.find('input[name="mac"]').addClass('input-warning');
    } else {
        $form.find('input[name="mac"]').removeClass('input-warning');
    }
    if (!mac) {
        $form.find('input[name="mac"]').addClass('input-warning');
    }
    if (ip && ip !== '0.0.0.0' && !isValidIpAddress(ip)) {
        errorMessage = 'Invalid IP Address';
        $form.find('input[name="ip"]').addClass('input-warning');
    } else if (!ip || ip === '0.0.0.0') {
        $form.find('input[name="ip"]').addClass('input-warning');
    } else {
        $form.find('input[name="ip"]').removeClass('input-warning');
    }

    // Validate utilities for Approving workstep only
    if (workstep === 'Approving' && utilities.length === 0) {
        errorMessage = 'Utilities required for Approving workstep';
        $form.find('select[name="utilities[]"]').addClass('input-warning');
        $form.find('select[name="utilities[]"]').next('.select2-container').addClass('input-warning');
    } else {
        $form.find('select[name="utilities[]"]').removeClass('input-warning');
        $form.find('select[name="utilities[]"]').next('.select2-container').removeClass('input-warning');
    }

    // Apply warning styles to required fields (exclude users)
    if (!hostname) {
        $form.find('input[name="hostname"]').addClass('input-warning');
    } else {
        $form.find('input[name="hostname"]').removeClass('input-warning');
    }
    if (!os) {
        $form.find('select[name="os"]').addClass('input-warning');
    } else {
        $form.find('select[name="os"]').removeClass('input-warning');
    }
    if (!dotnet) {
        $form.find('select[name="dotnet"]').addClass('input-warning');
    } else {
        $form.find('select[name="dotnet"]').removeClass('input-warning');
    }
    if (!workstep) {
        $form.find('select[name="hw_primary_role"]').addClass('input-warning');
    } else {
        $form.find('select[name="hw_primary_role"]').removeClass('input-warning');
    }
    if (!memory) {
        $form.find('select[name="hw_memory"]').addClass('input-warning');
    } else {
        $form.find('select[name="hw_memory"]').removeClass('input-warning');
    }
    if (!hdd_capacity) {
        $form.find('input[name="hdd_capacity"]').addClass('input-warning');
    } else {
        $form.find('input[name="hdd_capacity"]').removeClass('input-warning');
    }
    if (!hdd_free_space) {
        $form.find('input[name="hdd_free_space"]').addClass('input-warning');
    } else {
        $form.find('input[name="hdd_free_space"]').removeClass('input-warning');
    }
    // Do not apply input-warning to users
    $form.find('select[name="users"]').removeClass('input-warning');

    // Update status and toast for validation errors or valid input changes
    if (errorMessage) {
        $status.addClass('error').removeClass('text-success fw-semibold').text(errorMessage);
        showErrorToast(errorMessage);
    } else if ($changedInput) {
        const inputName = $changedInput.attr('name');
        const inputValue = inputName === 'utilities[]' ? utilities : $changedInput.val();
        let isValidInput = false;

        if (inputName === 'mac' && inputValue && isValidMacAddress(inputValue)) {
            isValidInput = true;
        } else if (inputName === 'ip' && inputValue && inputValue !== '0.0.0.0' && isValidIpAddress(inputValue)) {
            isValidInput = true;
        } else if (inputName === 'hostname' && inputValue) {
            isValidInput = true;
        } else if (inputName === 'os' && inputValue) {
            isValidInput = true;
        } else if (inputName === 'dotnet' && inputValue) {
            isValidInput = true;
        } else if (inputName === 'hw_primary_role' && inputValue) {
            isValidInput = true;
        } else if (inputName === 'hw_memory' && inputValue) {
            isValidInput = true;
        } else if (inputName === 'hdd_capacity' && inputValue) {
            isValidInput = true;
        } else if (inputName === 'hdd_free_space' && inputValue) {
            isValidInput = true;
        } else if (inputName === 'utilities[]') { // Allow empty utilities to save
            isValidInput = true;
        }

        if (isValidInput && inputName !== 'users' && !(inputName === 'mac' && !inputValue)) {
            $status.removeClass('error').text('Saving...');
            const prevTimer = $form.data('saveTimer');
            if (prevTimer) clearTimeout(prevTimer);

            const t = setTimeout(function () {
                // Send update to backend, excluding users
                $.ajax({
                    url: 'software-config-api.php',
                    type: 'POST',
                    data: {
                        action: 'updateHardware',
                        hw_asset_num: $accordionItem.data('asset-num'),
                        hw_serial_num: $accordionItem.data('serial-num'),
                        site_code: site_code,
                        region_id: region_id,
                        hw_host_name: hostname,
                        hw_mac_add: mac,
                        hw_ip_add: ip,
                        os_type: os,
                        dotnet: dotnet,
                        hw_primary_role: workstep,
                        hw_memory: memory,
                        hdd_capacity: hdd_capacity,
                        hdd_free_space: hdd_free_space,
                        utilities: utilities
                    },
                    dataType: 'json',
                    timeout: 10000, // 10-second timeout
                    success: function(response) {
                        if (response.success) {
                            $status.addClass('text-success fw-semibold')
                                .html('Successfully saved <i class="bi bi-check-circle-fill"></i>');
                        } else {
                            let message = 'Error saving: ' + response.message;
                            if (response.message.includes('SQLSTATE[HY000]') || response.message.includes('database')) {
                                message = 'Error saving: Database is unavailable. Please try again later.';
                            }
                            $status.addClass('error').removeClass('text-success fw-semibold').text(message);
                            showErrorToast(message);
                        }
                    },
                    error: function(xhr, status, error) {
                        let message = 'Error saving: Unable to reach the server. Please try again later.';
                        if (status === 'timeout') {
                            message = 'Error saving: Server took too long to respond. Please check your connection.';
                        } else if (xhr.status === 0) {
                            message = 'Error saving: Unable to connect to the server. Please check your network.';
                        }
                        $status.addClass('error').removeClass('text-success fw-semibold').text(message);
                        showErrorToast(message);
                        console.error('AJAX error (updateHardware):', status, error, xhr.responseText);
                    }
                });
            }, 900);
            $form.data('saveTimer', t);
        } else {
            $status.removeClass('error').removeClass('text-success fw-semibold').text('Auto update');
        }
    } else {
        $status.removeClass('error').removeClass('text-success fw-semibold').text('Auto update');
    }

    // Check for missing or invalid required fields (exclude users and utilities unless Approving)
    const hasMissingDetails = !hostname || !mac || !ip || ip === '0.0.0.0' || !os || !dotnet ||
        !workstep || !memory || !hdd_capacity || !hdd_free_space ||
        (workstep === 'Approving' && utilities.length === 0);

    if (hasMissingDetails) {
        $accordionItem.addClass('has-warning');
        $icon.removeClass('bi-pc-display').addClass('bi-exclamation-triangle');
        $status.removeClass('text-success fw-semibold');
    } else {
        $accordionItem.removeClass('has-warning');
        $icon.removeClass('bi-exclamation-triangle').addClass('bi-pc-display');
        $status.addClass('text-success fw-semibold').html('Successfully saved <i class="bi bi-check-circle-fill"></i>');
    }
}

$(document).on('input change', '.pe-form :input', function () {
    const $accordionItem = $(this).closest('.accordion-item');
    validateAccordion($accordionItem, $(this));
});

});