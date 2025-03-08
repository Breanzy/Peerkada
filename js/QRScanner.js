// qr-scanner.js - A reusable QR scanner module
const QRScanner = {
    // Properties
    scanner: null,
    config: {
        totalTime: 1000,
        updateInterval: 25,
    },
    elements: {},
    state: {
        currentStep: 0,
        progressInterval: null,
    },

    // Initialization
    init: function (options = {}) {
        // Get DOM elements
        this.elements = {
            reader: document.getElementById("qr-reader"),
            form: document.getElementById("qr-form"),
            input: document.getElementById("qr-code-value"),
            loading: document.getElementById("loading-container"),
            progress: document.getElementById("progress-indicator"),
        };

        // Override default config with any provided options
        Object.assign(this.config, options);

        // Initialize QR code scanner
        this.scanner = new Html5Qrcode("qr-reader");

        // Setup event listeners
        window.addEventListener(
            "resize",
            this.debounce(this.handleResize.bind(this), 300)
        );

        // Start progress animation
        this.startProgressAnimation();

        return this;
    },

    // Core methods
    startProgressAnimation: function () {
        const totalSteps = this.config.totalTime / this.config.updateInterval;
        const progressPerStep = 157 / totalSteps; // 157 is the total stroke-dasharray (2πr where r=25)

        this.state.progressInterval = setInterval(() => {
            this.state.currentStep++;

            // Calculate new progress value
            const newOffset = 157 - progressPerStep * this.state.currentStep;
            this.elements.progress.style.strokeDashoffset = newOffset;

            // Check if progress is complete
            if (this.state.currentStep >= totalSteps) {
                clearInterval(this.state.progressInterval);
                this.showQrScanner();
            }
        }, this.config.updateInterval);
    },

    showQrScanner: function () {
        // Fade out loading container
        this.elements.loading.style.opacity = "0";
        this.elements.loading.style.transition = "opacity 0.3s";

        // After fade out, hide loading and show QR reader
        setTimeout(() => {
            this.elements.loading.style.display = "none";
            this.elements.reader.style.display = "block";
            this.startScanner();
        }, 300);
    },

    startScanner: function () {
        const qrBoxSize = this.getQrBoxSize();

        // Config object for scanner
        const scannerConfig = {
            fps: 10,
            qrbox: qrBoxSize,
            aspectRatio: 1.0,
            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
        };

        // Start scanner with camera
        this.scanner
            .start(
                { facingMode: "environment" }, // Try to use back camera
                scannerConfig,
                this.onScanSuccess.bind(this)
            )
            .catch((err) => {
                console.error("Error starting QR scanner:", err);
            });
    },

    // Helper methods
    getQrBoxSize: function () {
        const containerWidth = this.elements.reader.clientWidth;
        const size = Math.min(containerWidth - 40, 250);
        return { width: size, height: size };
    },

    onScanSuccess: function (decodedText, decodedResult) {
        // Stop scanning after successful detection
        this.scanner.stop().then(() => {
            // Populate form and submit
            this.elements.input.value = decodedText;
            this.elements.form.submit();
        });
    },

    handleResize: function () {
        // Stop and restart the scanner on resize for proper adjustment
        this.scanner
            .stop()
            .then(() => {
                this.startScanner();
            })
            .catch((err) => {
                console.log("Stop error: ", err);
                // Try to start scanner anyway
                this.startScanner();
            });
    },

    debounce: function (func, wait) {
        let timeout;
        return function () {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    },
};
