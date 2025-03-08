// File: js/sweetAlertNotifications.js

/**
 * Display a SweetAlert notification
 * @param {string} type - The type of notification (success, error, warning, info)
 * @param {string} message - The message to display
 * @param {object} options - Additional SweetAlert options
 */
function showSweetAlert(type, message, options = {}) {
    // Set default configurations based on type
    const defaultConfig = {
        icon: type,
        title: type.charAt(0).toUpperCase() + type.slice(1) + "!",
        text: message,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        position: "top-end",
        toast: true,
    };

    // Merge default config with any custom options
    const config = { ...defaultConfig, ...options };

    // Show the SweetAlert
    Swal.fire(config);
}

/**
 * Check for notifications in URL parameters and display them
 * This function should be called on page load
 */
function checkUrlNotifications() {
    const urlParams = new URLSearchParams(window.location.search);
    const successMessage = urlParams.get("success");
    const errorMessage = urlParams.get("error");

    if (successMessage) {
        showSweetAlert("success", decodeURIComponent(successMessage));

        // Clean up the URL without reloading the page
        const newUrl = window.location.pathname + window.location.hash;
        window.history.replaceState({}, document.title, newUrl);
    }

    if (errorMessage) {
        showSweetAlert("error", decodeURIComponent(errorMessage));

        // Clean up the URL without reloading the page
        const newUrl = window.location.pathname + window.location.hash;
        window.history.replaceState({}, document.title, newUrl);
    }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
    checkUrlNotifications();
});
