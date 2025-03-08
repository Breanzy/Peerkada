/**
 * Reset Password Modal Handler
 */
const resetPasswordModal = {
    modal: null,
    confirmBtn: null,
    doneBtn: null,
    confirmationSection: null,
    resultSection: null,
    userName: null,
    newPasswordInput: null,
    confirmPasswordInput: null,
    userId: null,

    init: function () {
        this.modal = new bootstrap.Modal(
            document.getElementById("resetPasswordModal")
        );
        this.confirmBtn = document.getElementById("confirmResetBtn");
        this.doneBtn = document.getElementById("doneResetBtn");
        this.confirmationSection = document.getElementById(
            "confirmationSection"
        );
        this.resultSection = document.getElementById("resultSection");
        this.userName = document.getElementById("resetUserName");
        this.newPasswordInput = document.getElementById("inputNewPassword");
        this.confirmPasswordInput =
            document.getElementById("confirmNewPassword");

        // Reset modal state when hidden
        document
            .getElementById("resetPasswordModal")
            .addEventListener("hidden.bs.modal", () => {
                this.resetModalState();
            });

        // Set up confirmation button event
        this.confirmBtn.addEventListener("click", () => {
            if (this.validatePasswords()) {
                this.resetPassword();
            }
        });
    },

    showModal: function (userId, userName) {
        this.userId = userId;
        this.userName.textContent = userName || userId;
        this.modal.show();
    },

    validatePasswords: function () {
        const newPassword = this.newPasswordInput.value;
        const confirmPassword = this.confirmPasswordInput.value;

        // Check if password is empty
        if (!newPassword) {
            this.newPasswordInput.classList.add("is-invalid");
            return false;
        } else {
            this.newPasswordInput.classList.remove("is-invalid");
        }

        // Check if passwords match
        if (newPassword !== confirmPassword) {
            this.confirmPasswordInput.classList.add("is-invalid");
            return false;
        } else {
            this.confirmPasswordInput.classList.remove("is-invalid");
        }

        return true;
    },

    resetPassword: function () {
        // Disable the button and show loading state
        this.confirmBtn.disabled = true;
        this.confirmBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

        // Send AJAX request to reset password
        $.ajax({
            url: "../controllers/ResetPassword.php",
            method: "POST",
            data: {
                userId: this.userId,
                newPassword: this.newPasswordInput.value,
            },
            success: (response) => {
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        // Show success message
                        this.showResultSection();
                    } else {
                        showSweetAlert(
                            "error",
                            "Error resetting password: " + result.message
                        );
                        this.resetModalState();
                        this.modal.hide();
                    }
                } catch (e) {
                    console.error("Error parsing response:", response);
                    showSweetAlert("error", "Error processing server response");
                    this.resetModalState();
                    this.modal.hide();
                }
            },
            error: (xhr, status, error) => {
                showSweetAlert("error", "Error resetting password: " + error);
                console.error("AJAX Error:", status, error);
                this.resetModalState();
                this.modal.hide();
            },
        });
    },

    showResultSection: function () {
        this.confirmationSection.style.display = "none";
        this.resultSection.style.display = "block";
        this.confirmBtn.style.display = "none";
        this.doneBtn.style.display = "inline-block";
    },

    resetModalState: function () {
        this.confirmationSection.style.display = "block";
        this.resultSection.style.display = "none";
        this.confirmBtn.style.display = "inline-block";
        this.doneBtn.style.display = "none";
        this.confirmBtn.disabled = false;
        this.confirmBtn.innerHTML = "Reset Password";
        this.userId = null;
        this.userName.textContent = "";
        this.newPasswordInput.value = "";
        this.confirmPasswordInput.value = "";
        this.newPasswordInput.classList.remove("is-invalid");
        this.confirmPasswordInput.classList.remove("is-invalid");
    },
};

// Initialize when the DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    resetPasswordModal.init();
});
