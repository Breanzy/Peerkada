<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

<div class="card-body d-flex justify-content-center">
    <!-- Progress indicator - Just a circular progress bar -->
    <div id="loading-container">
        <svg id="progress-circle" width="60" height="60" viewBox="0 0 60 60">
            <circle cx="30" cy="30" r="25" fill="none" stroke="#e0e0e0" stroke-width="4"></circle>
            <circle id="progress-indicator" cx="30" cy="30" r="25" fill="none" stroke="#007bff" stroke-width="4" stroke-dasharray="157" stroke-dashoffset="157" transform="rotate(-90 30 30)"></circle>
        </svg>
    </div>

    <!-- QR scanner container (hidden initially) -->
    <div id="qr-reader" style="width: 100%; display: none; margin: 0 auto; max-width: 100%"></div>

    <!-- Hidden form for submission -->
    <form id="qr-form" action="../controllers/QR_Log_Insert.php" method="post">
        <input type="hidden" id="qr-code-value" name="text">
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrReaderElement = document.getElementById("qr-reader");
        const qrForm = document.getElementById("qr-form");
        const qrInput = document.getElementById("qr-code-value");
        const loadingContainer = document.getElementById("loading-container");
        const progressIndicator = document.getElementById("progress-indicator");

        // Progress bar animation variables
        const totalTime = 1000; // 1 second in milliseconds
        const updateInterval = 25; // Update every 25ms for smoother animation
        const totalSteps = totalTime / updateInterval;
        const progressPerStep = 157 / totalSteps; // 157 is the total stroke-dasharray value (2πr where r=25)
        let currentStep = 0;
        let progressInterval;

        // Create QR code scanner instance
        const html5QrCode = new Html5Qrcode("qr-reader");

        // Calculate the appropriate size for the QR code scanner
        function getQrBoxSize() {
            const containerWidth = qrReaderElement.clientWidth;
            const size = Math.min(containerWidth - 40, 250);
            return {
                width: size,
                height: size
            };
        }

        // Success callback function
        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanning after successful detection
            html5QrCode.stop().then(() => {
                // Populate form and submit
                qrInput.value = decodedText;
                qrForm.submit();
            });
        }

        // Function to handle window resize
        function handleResize() {
            // We need to stop and restart the scanner on resize for proper adjustment
            html5QrCode.stop().then(() => {
                startScanner();
            }).catch(err => {
                console.log("Stop error: ", err);
                // Try to start scanner anyway
                startScanner();
            });
        }

        // Debounce function to limit resize event calls
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    func.apply(context, args);
                }, wait);
            };
        }

        // Add resize listener with debouncing
        window.addEventListener('resize', debounce(handleResize, 300));

        // Function to update progress bar
        function updateProgressBar() {
            currentStep++;

            // Calculate new progress value
            const newOffset = 157 - (progressPerStep * currentStep);
            progressIndicator.style.strokeDashoffset = newOffset;

            // Check if progress is complete
            if (currentStep >= totalSteps) {
                clearInterval(progressInterval);
                showQrScanner();
            }
        }

        // Function to show QR scanner and hide loading
        function showQrScanner() {
            // Fade out loading container
            loadingContainer.style.opacity = "0";
            loadingContainer.style.transition = "opacity 0.3s";

            // After fade out, hide loading and show QR reader
            setTimeout(() => {
                loadingContainer.style.display = "none";
                qrReaderElement.style.display = "block";
                // Start the QR scanner
                startScanner();
            }, 300);
        }

        // Function to start the QR scanner
        function startScanner() {
            const qrBoxSize = getQrBoxSize();

            // Config object optimized for faster detection and responsive sizing
            const config = {
                fps: 10,
                qrbox: qrBoxSize,
                aspectRatio: 1.0,
                formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
            };

            // Start scanner with camera
            html5QrCode.start({
                    facingMode: "environment"
                }, // Try to use back camera
                config,
                onScanSuccess
            ).catch(err => {
                console.error("Error starting QR scanner:", err);
            });
        }

        // Start the progress bar animation
        progressInterval = setInterval(updateProgressBar, updateInterval);
    });
</script>