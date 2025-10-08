<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU Annual Inspection System</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="shortcut icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="css/index/welcome.css">
    <link rel="stylesheet" href="../../css/font/main.css">
    <script src="js/lottie.min.js"></script>
    <style>
        /* Slideshow viewport for welcome features */
        .features-viewport {
            overflow: hidden;
        }

        .features-viewport .welcome-features {
            will-change: transform;
        }
    </style>
</head>

<body class="body-welcome">
    <div class="welcome-container">

        <main class="welcome-main">
            <div class="welcome-left">
                <div class="welcome-header-container">
                    <div class="welcome-logo">
                        <img src="images/logo.png" alt="LGU Annual Inspection System">
                    </div>
                    <img class="welcome-title-img" src="images/Obo2.png" alt="LGU Annual Inspection System">
                </div>
                <p class="welcome-subtitle">Streamlining Municipal Inspections for Better Governance</p>
                <section class="welcome-description">
                    <p>
                        Welcome to the comprehensive digital platform designed to modernize and streamline
                        the annual inspection processes for Local Government Units. Our system provides
                        efficient tools for managing inspections across multiple departments, ensuring
                        compliance, transparency, and improved service delivery.
                    </p>
                </section>

                <section class="welcome-actions">
                    <a href="view/auth/Login.php" class="btn btn-primary">
                        <span>🔐</span>
                        Login here
                    </a>
                    <a href="#" class="btn btn-secondary">
                        <span>📋</span>
                        Learn More
                    </a>
                </section>
            </div>

            <div class="welcome-right">
                <div id="lottie-building" class="lottie-building"></div>
                <div class="features-viewport">
                    <section class="welcome-features">
                        <div class="feature-section">
                            <h3 class="feature-title">Electronics</h3>
                            <p class="feature-description">Manage electronic equipment inspections and compliance tracking</p>
                        </div>

                        <div class="feature-section">
                            <h3 class="feature-title">Electrical</h3>
                            <p class="feature-description">Comprehensive electrical system inspections and safety protocols</p>
                        </div>

                        <div class="feature-section">
                            <h3 class="feature-title">Mechanical</h3>
                            <p class="feature-description">Mechanical equipment maintenance and inspection management</p>
                        </div>
                        <div class="feature-section">
                            <h3 class="feature-title">Civil/Structural</h3>
                            <p class="feature-description">Structural assessments, building code compliance, and civil works inspections</p>
                        </div>
                        <div class="feature-section">
                            <h3 class="feature-title">Line & Grade</h3>
                            <p class="feature-description">Site layout verification, elevation checks, and right-of-way alignment</p>
                        </div>
                        <div class="feature-section">
                            <h3 class="feature-title">Architectural</h3>
                            <p class="feature-description">Architectural plan reviews, occupancy standards, and aesthetic compliance</p>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Initialize Lottie animation
        (function() {
            var container = document.getElementById('lottie-building');
            if (container && window.lottie) {
                window.lottie.loadAnimation({
                    container: container,
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: 'css/Building and Construction.json'
                });
            }
        })();
    </script>
    <script>
        (function() {
            var viewport = document.querySelector('.features-viewport');
            var list = viewport ? viewport.querySelector('.welcome-features') : null;
            if (!viewport || !list) return;

            var items = Array.prototype.slice.call(list.children);
            if (items.length === 0) return;

            var currentIndex = 0;
            var direction = 1; // 1 = downwards (next), -1 = upwards (prev)
            var intervalMs = 3000;
            var transitionMs = 600;

            list.style.transition = 'transform ' + transitionMs + 'ms ease';

            function getGapPx() {
                var styles = window.getComputedStyle(list);
                var gap = styles.rowGap || styles.gap || '0';
                var parsed = parseFloat(gap);
                return isNaN(parsed) ? 0 : parsed;
            }

            function getOffsetForIndex(index) {
                var gap = getGapPx();
                var total = 0;
                for (var i = 0; i < index; i++) {
                    total += items[i].offsetHeight + gap;
                }
                return -total;
            }

            function setViewportHeight() {
                viewport.style.height = items[currentIndex].offsetHeight + 'px';
            }

            function goToIndex(index) {
                currentIndex = index;
                list.style.transform = 'translateY(' + getOffsetForIndex(currentIndex) + 'px)';
            }

            function step() {
                var next = currentIndex + direction;
                if (next >= items.length - 1) {
                    next = items.length - 1;
                    direction = -1;
                } else if (next <= 0) {
                    next = 0;
                    direction = 1;
                }
                goToIndex(next);
            }

            // Adjust height after transition ends to match the new item
            list.addEventListener('transitionend', function() {
                setViewportHeight();
            });

            // Handle resize to keep offsets and height correct
            window.addEventListener('resize', function() {
                setViewportHeight();
                // re-apply transform using recalculated heights/gap
                list.style.transform = 'translateY(' + getOffsetForIndex(currentIndex) + 'px)';
            });

            // Init
            setViewportHeight();
            goToIndex(0);
            var timer = setInterval(step, intervalMs);
            // Optional: pause on hover
            viewport.addEventListener('mouseenter', function() {
                clearInterval(timer);
            });
            viewport.addEventListener('mouseleave', function() {
                timer = setInterval(step, intervalMs);
            });
        })();
    </script>
</body>

</html>