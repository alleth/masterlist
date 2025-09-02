$(document).ready(function() {

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
        if (!value || value.trim() === '') {
            return '0.0.0.0';
        }
        let cleaned = value.replace(/[^0-9.]/g, '');
        let parts = cleaned.split('.').filter(part => part !== '');
        parts = parts.slice(0, 4).map(part => part.length > 0 ? part.substring(0, 3) : '0');
        while (parts.length < 4) {
            parts.push('0');
        }
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
        url: 'server-config-api.php',
        type: 'POST',
        data: { action: 'getRegions' },
        dataType: 'json',
        timeout: 10000,
        success: function(response) {
            if (response.success) {
                let regionSelect = $('#ServerRegionSelect');
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
    $('#ServerRegionSelect').change(function() {
        let regionId = $(this).val();
        let siteSelect = $('#ServerSiteSelect');

        siteSelect.empty().append('<option value="" disabled>Select Site</option>');

        if (!regionId) {
            siteSelect.prop('disabled', true);
            return;
        }

        siteSelect.prop('disabled', false);

        $.ajax({
            url: 'server-config-api.php',
            type: 'POST',
            data: {
                action: 'getSitesByRegion',
                region_id: regionId
            },
            dataType: 'json',
            timeout: 10000,
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

    // Handle show button click
    $('#showServerButton').click(function() {
        let regionId = $('#ServerRegionSelect').val();
        let siteCode = $('#ServerSiteSelect').val();

        if (!regionId || !siteCode) {
            let toastEl = document.getElementById('toastValidation');
            let toast = new bootstrap.Toast(toastEl);
            toast.show();
            return;
        }

        $.ajax({
            url: 'server-config-api.php',
            type: 'POST',
            data: {
                action: 'getHardware',
                region_id: regionId,
                site_code: siteCode
            },
            dataType: 'json',
            timeout: 10000,
            beforeSend: function() {
                var showButton = document.getElementById('showServerButton');
                if (showButton) {
                    showButton.disabled = true;
                }

                $("#accordionExample").empty();
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
                var showButton = document.getElementById('showServerButton');
                if (showButton) {
                    showButton.disabled = false;
                }
                if (response.success) {
                    let accordion = $('#accordionExample');
                    accordion.empty();

                    if (response.data.length === 0) {
                        accordion.html('<p class="text-muted text-center fst-italic">No hardware found.</p>');
                        return;
                    }

                    console.log('Hardware data:', response.data);

                    response.data.forEach(function(hw, index) {
                        const hasMissingDetails = !hw.hw_host_name || !hw.hw_mac_add || !hw.hw_ip_add ||
                            hw.hw_ip_add === '0.0.0.0' || !hw.os_type || !hw.dotnet ||
                            !hw.hw_memory || !hw.hdd_capacity || !hw.hdd_free_space;

                        const warningClass = hasMissingDetails ? 'has-warning' : '';
                        const iconClass = hasMissingDetails ? 'bi-exclamation-triangle' : 'bi-server';

                        const ipValue = hw.hw_ip_add ? formatIpAddress(hw.hw_ip_add) : '0.0.0.0';

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
                                                <label class="form-label">Server OS Version</label>
                                                <select class="form-select" name="os">
                                                    <option value="" ${!hw.os_type ? 'selected' : ''}>Select Server OS Version</option>
                                                    <option value="Windows Server 2003" ${hw.os_type === 'Windows Server 2003' ? 'selected' : ''}>Windows Server 2003</option>
                                                    <option value="Windows Server 2008" ${hw.os_type === 'Windows Server 2008' ? 'selected' : ''}>Windows Server 2008</option>
                                                    <option value="Windows Server 2008 R2" ${hw.os_type === 'Windows Server 2008 R2' ? 'selected' : ''}>Windows Server 2008 R2</option>
                                                    <option value="Windows Server 2012" ${hw.os_type === 'Windows Server 2012' ? 'selected' : ''}>Windows Server 2012</option>
                                                    <option value="Windows Server 2016" ${hw.os_type === 'Windows Server 2016' ? 'selected' : ''}>Windows Server 2016</option>
                                                    <option value="Windows Server 2019" ${hw.os_type === 'Windows Server 2019' ? 'selected' : ''}>Windows Server 2019</option>
                                                    <option value="Windows Server 2022" ${hw.os_type === 'Windows Server 2022' ? 'selected' : ''}>Windows Server 2022</option>
                                                    <option value="Windows Server 2025" ${hw.os_type === 'Windows Server 2025' ? 'selected' : ''}>Windows Server 2025</option>
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
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">HDD Capacity</label>
                                                <input type="text" class="form-control" name="hdd_capacity" value="${hw.hdd_capacity || ''}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">HDD Free Space</label>
                                                <input type="text" class="form-control" name="hdd_free_space" value="${hw.hdd_free_space || ''}">
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

                        const $accordionItem = $(accordionItem);
                        accordion.append($accordionItem);

                        const $macInput = $accordionItem.find('.mac-address');
                        const $ipInput = $accordionItem.find('.ip-address');

                        $macInput.on('input', function() {
                            const $this = $(this);
                            const cursorPosition = this.selectionStart;
                            const originalLength = this.value.length;
                            const formatted = formatMacAddress(this.value);
                            $this.val(formatted);

                            const newLength = formatted.length;
                            const addedChars = newLength - originalLength;
                            this.setSelectionRange(cursorPosition + addedChars, cursorPosition + addedChars);

                            validateAccordion($accordionItem, $this);
                        });

                        function parseIpParts(val) {
                            if (!val) return ['0', '0', '0', '0'];
                            let parts = val.replace(/[^0-9.]/g, '').split('.');
                            while (parts.length < 4) parts.push('0');
                            parts = parts.slice(0, 4).map(p => (p === '' ? '0' : p.substring(0, 3)));
                            return parts;
                        }
                        function getOctetStart(parts, idx) {
                            let pos = 0;
                            for (let i = 0; i < idx; i++) pos += parts[i].length + 1;
                            return pos;
                        }
                        function setCursorPos(input, parts, idx, offset) {
                            const start = getOctetStart(parts, idx);
                            const pos = start + Math.max(0, Math.min(offset, parts[idx].length));
                            input.setSelectionRange(pos, pos);
                        }
                        function replaceRangeInOctet(oct, start, end, insert) {
                            const base = (oct === '0' && start === 0 && end === 1) ? '' : oct;
                            const next = (base.slice(0, start) + (insert || '') + base.slice(end)).slice(0, 3);
                            return next.length ? next : '0';
                        }

                        $ipInput.on('keydown input', function(e) {
                            let value = this.value.replace(/[^0-9.]/g, '');
                            let parts = value.split('.');

                            while (parts.length < 4) parts.push("0");
                            parts = parts.slice(0, 4);

                            parts = parts.map(p => p === "" ? "0" : p.substring(0, 3));

                            let formatted = parts.join(".");
                            this.value = formatted;

                            const cursorPos = this.selectionStart;
                            const key = e.key;

                            let octetIndex = formatted.substring(0, cursorPos).split('.').length - 1;

                            if (/^[0-9]$/.test(key)) {
                                if (parts[octetIndex].length >= 3 && octetIndex < 3) {
                                    let nextPos = formatted.indexOf('.', cursorPos) + 1;
                                    this.setSelectionRange(nextPos, nextPos);
                                }
                            }

                            if (key === ".") {
                                e.preventDefault();
                                if (octetIndex < 3) {
                                    let nextPos = formatted.indexOf('.', cursorPos) + 1;
                                    this.setSelectionRange(nextPos, nextPos);
                                }
                            }

                            if (key === "Backspace" || key === "Delete") {
                                setTimeout(() => {
                                    let v = this.value.replace(/[^0-9.]/g, '');
                                    let p = v.split('.');
                                    while (p.length < 4) p.push("0");
                                    p = p.map(x => x === "" ? "0" : x.substring(0, 3));
                                    this.value = p.slice(0, 4).join(".");
                                });
                            }

                            validateAccordion($accordionItem, $(this));
                        });

                        $ipInput.on('blur', function() {
                            this.value = parseIpParts(this.value).join('.');
                            validateAccordion($accordionItem, $(this));
                        });

                        validateAccordion($accordionItem);
                    });
                } else {
                    showErrorToast('Failed to load hardware: ' + response.message);
                    console.error('Error fetching hardware:', response.message);
                    $("#accordionExample").html('<p class="text-muted text-center fst-italic">Failed to load hardware. Please try again.</p>');
                }
            },
            error: function(xhr, status, error) {
                var showButton = document.getElementById('showServerButton');
                if (showButton) {
                    showButton.disabled = false;
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

    // Real-time status and validation per accordion item
    function validateAccordion($accordionItem, $changedInput = null) {
        const $form = $accordionItem.find('.pe-form');
        const $status = $accordionItem.find('.accordion-footer .status');
        const $icon = $accordionItem.find('.accordion-button .bi');

        const hostname = $form.find('input[name="hostname"]').val();
        const mac = $form.find('input[name="mac"]').val();
        const ip = $form.find('input[name="ip"]').val();
        const os = $form.find('select[name="os"]').val();
        const dotnet = $form.find('select[name="dotnet"]').val();
        const memory = $form.find('select[name="hw_memory"]').val();
        const hdd_capacity = $form.find('input[name="hdd_capacity"]').val();
        const hdd_free_space = $form.find('input[name="hdd_free_space"]').val();
        const region_id = $('#ServerRegionSelect').val();
        const site_code = $('#ServerSiteSelect').val();

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

        if (errorMessage) {
            $status.addClass('error').removeClass('text-success fw-semibold').text(errorMessage);
            showErrorToast(errorMessage);
        } else if ($changedInput) {
            const inputName = $changedInput.attr('name');
            const inputValue = $changedInput.val();
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
            } else if (inputName === 'hw_memory' && inputValue) {
                isValidInput = true;
            } else if (inputName === 'hdd_capacity' && inputValue) {
                isValidInput = true;
            } else if (inputName === 'hdd_free_space' && inputValue) {
                isValidInput = true;
            }

            if (isValidInput && inputName !== 'mac' || (inputName === 'mac' && inputValue)) {
                $status.removeClass('error').text('Saving...');
                const prevTimer = $form.data('saveTimer');
                if (prevTimer) clearTimeout(prevTimer);

                const t = setTimeout(function() {
                    $.ajax({
                        url: 'server-config-api.php',
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
                            hw_memory: memory,
                            hdd_capacity: hdd_capacity,
                            hdd_free_space: hdd_free_space
                        },
                        dataType: 'json',
                        timeout: 10000,
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

        const hasMissingDetails = !hostname || !mac || !ip || ip === '0.0.0.0' || !os || !dotnet ||
            !memory || !hdd_capacity || !hdd_free_space;

        if (hasMissingDetails) {
            $accordionItem.addClass('has-warning');
            $icon.removeClass('bi-server').addClass('bi-exclamation-triangle');
            $status.removeClass('text-success fw-semibold');
        } else {
            $accordionItem.removeClass('has-warning');
            $icon.removeClass('bi-exclamation-triangle').addClass('bi-server');
            $status.addClass('text-success fw-semibold').html('Successfully saved <i class="bi bi-check-circle-fill"></i>');
        }
    }

    $(document).on('input change', '.pe-form :input', function() {
        const $accordionItem = $(this).closest('.accordion-item');
        validateAccordion($accordionItem, $(this));
    });
});