/**
 * User Profile Edit Modal Handler
 * This script provides functionality for the Edit User Modal component
 */

class UserEditModal {
    constructor() {
        // Initialize modal if not already done
        this.modal = null;
        this.setupModal();
    }

    setupModal() {
        // Check if modal already exists in DOM
        if (document.getElementById("editUserModal")) {
            this.modal = new bootstrap.Modal(
                document.getElementById("editUserModal")
            );
            this.setupEventListeners();
        } else {
            // Load modal via AJAX if not already in DOM
            fetch("../js/EditUserModal.php")
                .then((response) => response.text())
                .then((html) => {
                    // Append modal to body
                    document.body.insertAdjacentHTML("beforeend", html);
                    // Initialize Bootstrap modal
                    this.modal = new bootstrap.Modal(
                        document.getElementById("editUserModal")
                    );
                    this.setupEventListeners();
                })
                .catch((error) => {
                    console.error("Error loading modal:", error);
                    showSweetAlert("error", "Failed to load edit user modal");
                });
        }
    }

    setupEventListeners() {
        // Setup save button event listener
        document
            .getElementById("saveUser")
            .addEventListener("click", () => this.saveUserData());

        // Handle modal close events to clean up
        document
            .getElementById("editUserModal")
            .addEventListener("hidden.bs.modal", () => {
                // Optional cleanup code here
            });
    }

    loadUserData(userData) {
        // Set user data in modal fields
        document.getElementById("modalUserName").textContent =
            userData.name || "";
        document.getElementById("userId").value = userData.userId || "";
        document.getElementById("name").value = userData.name || "";
        document.getElementById("idNumber").value = userData.idNumber || "";

        // Set select elements
        const titleSelect = document.getElementById("title");
        for (let i = 0; i < titleSelect.options.length; i++) {
            if (titleSelect.options[i].value === userData.title) {
                titleSelect.selectedIndex = i;
                break;
            }
        }

        document.getElementById("college").value = userData.college || "";
        document.getElementById("schoolYear").value = userData.schoolYear || "";
        document.getElementById("course").value = userData.course || "";
        document.getElementById("email").value = userData.email || "";
        document.getElementById("phone").value = userData.phone || "";
        document.getElementById("address").value = userData.address || "";
        document.getElementById("birthDate").value = userData.birthDate || "";

        const sexSelect = document.getElementById("sex");
        for (let i = 0; i < sexSelect.options.length; i++) {
            if (sexSelect.options[i].value === userData.sex) {
                sexSelect.selectedIndex = i;
                break;
            }
        }
    }

    showModal() {
        if (this.modal) {
            this.modal.show();
        } else {
            console.error("Modal not initialized");
            showSweetAlert(
                "error",
                "Could not display the edit form. Please try again."
            );
        }
    }

    hideModal() {
        if (this.modal) {
            this.modal.hide();
        }
    }

    saveUserData() {
        // Collect form data
        const formData = {
            userId: document.getElementById("userId").value,
            name: document.getElementById("name").value,
            idNumber: document.getElementById("idNumber").value,
            title: document.getElementById("title").value,
            college: document.getElementById("college").value,
            schoolYear: document.getElementById("schoolYear").value,
            course: document.getElementById("course").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            address: document.getElementById("address").value,
            birthDate: document.getElementById("birthDate").value,
            sex: document.getElementById("sex").value,
        };

        // Validate inputs
        if (!formData.name || !formData.idNumber) {
            showSweetAlert("warning", "Name and ID Number are required fields");
            return;
        }

        // Show loading state
        Swal.fire({
            title: "Saving...",
            text: "Updating user information",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        // Send AJAX request
        fetch("../controllers/UpdateUsers.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: this.objectToFormData(formData),
        })
            .then((response) => response.json())
            .then((result) => {
                if (result.success) {
                    // Hide modal
                    this.hideModal();

                    // Check if there were asset updates
                    let message = "User information updated successfully!";
                    if (result.assetResults && result.assetResults.updated) {
                        // Log the asset updates but don't confuse the user with too much detail
                        console.log("Asset updates:", result.assetResults);
                        message =
                            "User information and associated files updated successfully!";
                    }

                    // Show success message
                    showSweetAlert("success", message, {
                        timer: 2000,
                        timerProgressBar: true,
                        willClose: () => {
                            // Reload page to refresh data
                            window.location.reload();
                        },
                    });
                } else {
                    showSweetAlert(
                        "error",
                        "Error updating user: " + result.message
                    );
                }
            })
            .catch((error) => {
                showSweetAlert("error", "Error updating user: " + error);
                console.error("AJAX Error:", error);
            });
    }
    objectToFormData(obj) {
        return Object.keys(obj)
            .map(
                (key) =>
                    encodeURIComponent(key) + "=" + encodeURIComponent(obj[key])
            )
            .join("&");
    }
}

// Initialize the class when the script is loaded
const userEditModal = new UserEditModal();
