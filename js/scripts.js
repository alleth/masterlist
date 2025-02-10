window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

$(document).ready(function () {
    $(".datepicker-input").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showAnim: "fadeIn",
        autoclose: true,
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    position: "absolute",
                    top: $(input).offset().top + $(input).outerHeight(),
                    left: $(input).offset().left,
                    zIndex: 99999, // Ensures it's above the modal
                });
            }, 10);
        }
    });

    // Fix Bootstrap modal z-index issue
    $(document).on("focus", ".datepicker-input", function () {
        $(".ui-datepicker").css("z-index", 99999);
    });

    // Ensure correct positioning when modal is opened
    $(".modal").on("shown.bs.modal", function () {
        $(".ui-datepicker").css("z-index", parseInt($(this).css("z-index")) + 1);
    });
});
