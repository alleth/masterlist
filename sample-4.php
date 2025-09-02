<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Accordion Form with Auto Save</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons (for the success check) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .accordion-footer {
            padding: .75rem 1.25rem;
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            font-size: 0.9rem;
        }

        /* Make Select2 look like a Bootstrap control */
        .select2-container .select2-selection--multiple {
            min-height: 38px;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            padding: 2px 6px;
        }

        /* Selected tags: blue chip + “×” placed AFTER the text */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd;  /* Bootstrap primary */
            border: none;
            color: #fff;
            padding: 2px 8px;
            margin-top: 4px;
            margin-right: 4px;
            border-radius: .25rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;                   /* space between label and × */
        }

        /* Hide Select2’s built-in remove (it appears before text) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            display: none !important;
        }

        /* Our custom × after the text (clickable) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice .chip-x {
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            user-select: none;
            line-height: 0;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice .chip-x:hover {
            color: #e77c7c; /* yellow on hover */
        }

        /* Add a checkmark in the dropdown for selected items */
        .select2-results__option[aria-selected="true"]::before,
        .select2-results__option.select2-results__option--selected::before {
            content: "✓";
            display: inline-block;
            margin-right: 8px;
            font-weight: 700;
        }
        .select2-results__option::before {
            content: "";
            display: inline-block;
            width: 1em;
            margin-right: 8px;
        }
    </style>
</head>
<body class="p-4 bg-light">

<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Accordion Form
        </div>
        <div class="card-body">
            <div class="accordion" id="accordionExample">

                <!-- Accordion Item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            PE 12345
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form class="pe-form">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Hostname</label>
                                        <input type="text" class="form-control" name="hostname">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">MAC Address</label>
                                        <input type="text" class="form-control" name="mac">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">IP Address</label>
                                        <input type="text" class="form-control" name="ip">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">OS Version</label>
                                        <select class="form-select" name="os">
                                            <option value = "Windows XP">Windows XP</option>
                                            <option value = "Windows 10"= >Windows 10</option>
                                            <option value = "Windows 11">Windows 11</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">.NET Framework</label>
                                        <select class="form-select" name="dotnet">
                                            <option value="v4.0">4.0</option>
                                            <option value="4.5">4.5</option>
                                            <option value="4.7">4.7</option>
                                            <option value="4.8">4.8</option>
                                            <option value="5.0">5.0</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Users</label>
                                        <select class="form-select" name="users">
                                            <option>User1</option>
                                            <option>User2</option>
                                            <option>User3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">User Role</label>
                                        <select class="form-multi roles" name="roles[]" multiple style="width:100%">
                                            <option>Approving Officer</option>
                                            <option>Evaluator</option>
                                            <option>Input Clerk</option>
                                            <option>Cashier</option>
                                            <option>Releasing Officer</option>
                                            <option>Hearing Officer</option>
                                            <option>PhotoSig</option>
                                            <option>Data Encoder</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Utilities</label>
                                        <select class="form-multi utilities" name="utilities[]" multiple style="width:100%">
                                            <option>MV Maintenance</option>
                                            <option>MV DTO</option>
                                            <option>DL DTO</option>
                                            <option>RSU Facility</option>
                                            <option>DL DTO</option>
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
                <!-- /Accordion Item -->

            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Bootstrap 5 JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function () {
        // Initialize Select2 on the multi-selects, keep dropdown inside accordion panel
        $('.form-multi').each(function () {
            $(this).select2({
                placeholder: "Select options",
                closeOnSelect: false,
                width: '100%',
                dropdownParent: $(this).closest('.accordion-body'),
                // Custom selection renderer: label + our trailing ×
                templateSelection: function (data) {
                    if (!data.id) return data.text;
                    const $wrap  = $('<span class="chip-wrap"></span>');
                    const $label = $('<span class="chip-label"></span>').text(data.text);
                    const $x     = $('<span class="chip-x" aria-hidden="true" title="Remove">&nbsp; ×</span>');
                    $wrap.append($label).append($x);
                    return $wrap;
                }
            });
        });

        // Click on our custom × to unselect that item
        $(document).on('click', '.select2-selection__choice .chip-x', function (e) {
            e.stopPropagation();
            const $choice = $(this).closest('.select2-selection__choice');
            const label   = $choice.find('.chip-label').text();
            const $select = $(this).closest('.select2-container').prev('select');

            // Find option by text and unselect it
            const $opt = $select.find('option').filter(function(){ return $(this).text() === label; });
            if ($opt.length) {
                $opt.prop('selected', false);
                $select.trigger('change');
            }
        });

        // Real-time status per accordion item
        $(document).on('input change', '.pe-form :input', function () {
            const $form   = $(this).closest('.pe-form');
            const $status = $form.closest('.accordion-item').find('.accordion-footer .status');

            $status.removeClass('text-success fw-semibold').text('Saving...');
            const prevTimer = $form.data('saveTimer');
            if (prevTimer) clearTimeout(prevTimer);

            const t = setTimeout(function () {
                $status.addClass('text-success fw-semibold')
                    .html('Successfully saved <i class="bi bi-check-circle-fill"></i>');
            }, 900);

            $form.data('saveTimer', t);
        });
    });
</script>
</body>
</html>
