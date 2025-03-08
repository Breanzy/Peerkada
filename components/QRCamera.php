<!-- External dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<!-- Your QR Scanner module -->
<script src="../js/QrScanner.js"></script>

<div class="card">
    <div class="card-header">
        <i class="fa fa-camera " aria-hidden="true"></i>
        QR Scanner
    </div>
    <div class="card-body d-flex justify-content-center">
        <!-- Progress indicator -->
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
</div>




<!-- Initialize the QR scanner when the DOM is ready -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize QR scanner with custom options if needed
        QRScanner.init({
            // You can override default options here
            // totalTime: 2000, // 2 seconds instead of 1
        });
    });
</script>