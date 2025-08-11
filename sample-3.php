<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Slide Modal with Progress, Save, and Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-inner {
            min-height: 200px;
        }

        .carousel-item {
            text-align: center;
            padding: 30px;
        }

        /* Progress Line + Dots */
        .progress-guide {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin-bottom: 20px;
        }

        .progress-guide::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 15px;
            right: 15px;
            height: 4px;
            background: #dee2e6;
            z-index: 0;
            transform: translateY(-50%);
        }

        .progress-dot {
            position: relative;
            width: 20px;
            height: 20px;
            background: #dee2e6;
            border-radius: 50%;
            z-index: 1;
            transition: background-color 0.3s ease;
        }

        .progress-dot.active {
            background: #14B8A6;
        }

        .progress-line-fill {
            position: absolute;
            top: 50%;
            left: 15px;
            height: 4px;
            background: #14B8A6;
            z-index: 0;
            transform: translateY(-50%);
            transition: width 0.3s ease;
            width: 0;
        }
    </style>
</head>
<body>

<!-- Button to Open Modal -->
<div class="text-center mt-5">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slidePulloutModal">Open Slideshow Modal</button>
</div>

<!-- Pullout Modal -->
<div class="modal fade" id="slidePulloutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Slide Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Slide Guide -->
                <div class="progress-guide px-4">
                    <div class="progress-line-fill"></div>
                    <div class="progress-dot" data-step="0"></div>
                    <div class="progress-dot" data-step="1"></div>
                    <div class="progress-dot" data-step="2"></div>
                    <div class="progress-dot" data-step="3"></div>
                </div>

                <!-- Slides -->
                <div id="carouselSlides" class="carousel slide" data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <h4>Slide 1</h4>
                            <p>This is the first slide.</p>
                        </div>
                        <div class="carousel-item">
                            <h4>Slide 2</h4>
                            <p>This is the second slide.</p>
                        </div>
                        <div class="carousel-item">
                            <h4>Slide 3</h4>
                            <p>This is the third slide.</p>
                        </div>
                        <div class="carousel-item">
                            <h4>Slide 4</h4>
                            <p>This is the final slide.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer justify-content-between">
                <button id="prevBtn" class="btn btn-primary" disabled>Previous</button>
                <button id="nextBtn" class="btn btn-primary">Next</button>
            </div>

        </div>
    </div>
</div>

<!-- jQuery + Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        const $carousel = $('#carouselSlides');
        const $dots = $('.progress-dot');
        const $lineFill = $('.progress-line-fill');

        let carousel;

        // Initialize Carousel
        function initCarousel() {
            carousel = new bootstrap.Carousel($carousel[0], {
                interval: false,
                wrap: false
            });
        }

        // Reset everything (slides, dots, line, buttons)
        function resetSlides() {
            $carousel.find('.carousel-item').removeClass('active');
            $carousel.find('.carousel-item').first().addClass('active');

            $dots.removeClass('active');
            $dots.first().addClass('active');
            $lineFill.css('width', '0');

            $('#prevBtn').prop('disabled', true);
            $('#nextBtn').text('Next').removeClass('btn-success').addClass('btn-primary');
        }

        // Update buttons and progress on slide change
        function updateUI() {
            const total = $dots.length;
            const index = $carousel.find('.carousel-item.active').index();

            $dots.removeClass('active');
            $dots.each(function (i) {
                if (i <= index) $(this).addClass('active');
            });

            const guideWidth = $('.progress-guide').width();
            const leftOffset = 15;
            const percent = (index / (total - 1));
            const fillWidth = ((guideWidth - leftOffset * 2) * percent);
            $lineFill.css('width', fillWidth + 'px');

            $('#prevBtn').prop('disabled', index === 0);
            if (index === total - 1) {
                $('#nextBtn').text('Save').removeClass('btn-primary').addClass('btn-success');
            } else {
                $('#nextBtn').text('Next').removeClass('btn-success').addClass('btn-primary');
            }
        }

        // Handle next/save button
        $('#nextBtn').click(function () {
            const index = $carousel.find('.carousel-item.active').index();
            const lastIndex = $dots.length - 1;

            if (index === lastIndex) {
                alert('Saved successfully!');
                $('#slideModal').modal('hide'); // Hide modal (reset happens after hidden)
            } else {
                carousel.next();
            }
        });

        // Previous button
        $('#prevBtn').click(function () {
            carousel.prev();
        });

        // Update on slide
        $carousel.on('slid.bs.carousel', updateUI);

        // On modal fully shown, initialize carousel and UI
        $('#slideModal').on('shown.bs.modal', function () {
            initCarousel();
            updateUI();
        });

        // On modal fully hidden, dispose carousel and reset slides
        $('#slideModal').on('hidden.bs.modal', function () {
            if (carousel) {
                carousel.dispose(); // Properly dispose
                carousel = null;
            }
            resetSlides(); // Reset everything
        });
    });
</script>

</body>
</html>
