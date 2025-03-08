// UserTableManager.js - A module to handle user table functionality
const UserTableManager = {
    // Properties
    table: null,
    tableId: "userTable",

    // Initialization
    init: function (options = {}) {
        // Merge default options with provided options
        const config = Object.assign(
            {
                tableId: this.tableId,
                pageLength: 5,
                enableButtons: true,
            },
            options
        );

        this.tableId = config.tableId;

        // Initialize DataTable
        this.initDataTable(config);

        // Set up event handlers
        this.setupEventHandlers();

        return this;
    },

    // Initialize DataTable
    initDataTable: function (config) {
        const dtConfig = {
            lengthChange: false,
            pageLength: config.pageLength,
            responsive: true,
            scrollX: true,
            columnDefs: [
                {
                    className: "text-center align-middle",
                    targets: "_all",
                },
            ],
            buttons: config.enableButtons
                ? [
                      {
                          text: "View ",
                          className: "btn btn-dark",
                          extend: "colvis",
                      },
                      {
                          text: 'Excel <i class="fas fa-file-excel"></i>',
                          className: "btn btn-outline-success btn-light",
                          extend: "excelHtml5",
                          exportOptions: {
                              columns: ":visible",
                          },
                      },
                  ]
                : [],
            // Add initialization complete callback
            initComplete: function () {
                // Initial adjustment of columns
                this.api().columns.adjust().draw();
            },
        };

        this.table = $("#" + this.tableId).DataTable(dtConfig);

        if (config.enableButtons) {
            this.table
                .buttons()
                .container()
                .appendTo("#" + this.tableId + "_wrapper .col-md-6:eq(0)");
        }
    },

    // Set up event handlers for table actions
    setupEventHandlers: function () {
        const tableSelector = "#" + this.tableId;

        // QR Code download handler
        $(tableSelector).on("click", ".qr-btn", (e) =>
            this.handleQRDownload(e)
        );

        // Delete user handler
        $(tableSelector).on("click", ".delete-btn", (e) =>
            this.handleDeleteUser(e)
        );

        // Edit user handler
        $(tableSelector).on("click", ".edit-btn", (e) =>
            this.handleEditUser(e)
        );
    },

    // Helper method to get row data
    getRowData: function (element) {
        let $row = $(element).closest("tr");

        // Handle responsive mode child rows
        if ($row.hasClass("child")) {
            $row = $row.prev();
        }

        const tableRow = this.table.row($row);
        const userId = $row.data("user-id");
        const cells = tableRow.nodes().to$().find("td");

        return {
            $row: $row,
            tableRow: tableRow,
            userId: userId,
            cells: cells,
            // Extract common user data
            userData: {
                userId: userId,
                name: $(cells[0]).text().trim(),
                idNumber: $(cells[1]).text().trim(),
                title: $(cells[2]).text().trim(),
                college: $(cells[3]).text().trim(),
                schoolYear: $(cells[4]).text().trim(),
                course: $(cells[5]).text().trim(),
                email: $(cells[6]).text().trim(),
                phone: $(cells[7]).text().trim(),
                address: $(cells[8]).text().trim(),
                birthDate: $(cells[9]).text().trim(),
                sex: $(cells[10]).text().trim(),
            },
        };
    },

    // Handle QR code download
    handleQRDownload: function (event) {
        const rowData = this.getRowData(event.currentTarget);
        const userName = rowData.userData.name;
        const userId = rowData.userData.idNumber;

        // First generate/ensure QR code exists
        $.ajax({
            url: "../controllers/QRCodeAPI.php",
            method: "POST",
            data: {
                action: "generate",
                userId: userId,
                name: userName,
            },
            success: (response) => {
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        // Create form for download
                        const form = document.createElement("form");
                        form.method = "POST";
                        form.action = "../controllers/QRCodeAPI.php";

                        const actionInput = document.createElement("input");
                        actionInput.type = "hidden";
                        actionInput.name = "action";
                        actionInput.value = "download";

                        const userIdInput = document.createElement("input");
                        userIdInput.type = "hidden";
                        userIdInput.name = "userId";
                        userIdInput.value = userId;

                        form.appendChild(actionInput);
                        form.appendChild(userIdInput);
                        document.body.appendChild(form);
                        form.submit();
                        document.body.removeChild(form);
                    } else {
                        showSweetAlert(
                            "error",
                            "Error generating QR code: " + result.error
                        );
                    }
                } catch (e) {
                    showSweetAlert("error", "Error processing server response");
                    console.error("Response:", response);
                    console.error("Error:", e);
                }
            },
            error: (xhr, status, error) => {
                let errorMessage = "Error generating QR code";
                try {
                    const response = JSON.parse(xhr.responseText);
                    errorMessage = response.error || errorMessage;
                } catch (e) {
                    console.error("Raw server error:", xhr.responseText);
                }
                showSweetAlert("error", errorMessage);
            },
        });
    },

    // Handle user deletion
    handleDeleteUser: function (event) {
        const rowData = this.getRowData(event.currentTarget);
        const userName = rowData.userData.name;
        const userId = rowData.userData.idNumber;

        // Show SweetAlert confirmation dialog with user name
        Swal.fire({
            title: "Are you sure?",
            text: `Are you sure you want to delete the user "${userName}"? This action cannot be undone.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../controllers/DeleteUser.php",
                    method: "POST",
                    data: {
                        userId: userId,
                    },
                    success: (response) => {
                        try {
                            const result = JSON.parse(response);
                            if (result.success) {
                                // Animate row removal and remove from DataTable
                                rowData.$row.fadeOut(400, () => {
                                    this.table
                                        .row(rowData.$row)
                                        .remove()
                                        .draw();
                                });
                                showSweetAlert(
                                    "success",
                                    "User deleted successfully!"
                                );
                            } else {
                                showSweetAlert(
                                    "error",
                                    "Error deleting user: " + result.message
                                );
                            }
                        } catch (e) {
                            showSweetAlert(
                                "error",
                                "Error processing server response"
                            );
                            console.error("Response:", response);
                            console.error("Error:", e);
                        }
                    },
                    error: (xhr, status, error) => {
                        showSweetAlert(
                            "error",
                            "Error deleting user: " + error
                        );
                        console.error("AJAX Error:", status, error);
                    },
                });
            }
        });
    },

    // Handle user editing
    handleEditUser: function (event) {
        const rowData = this.getRowData(event.currentTarget);

        // We need access to the original cells to update them after edit
        const cells = rowData.cells;
        const $row = rowData.$row;
        const table = this.table;

        // Load and show modal (assuming userEditModal is globally available)
        userEditModal.loadUserData(rowData.userData);
        userEditModal.showModal();

        // Set up one-time event handler for data update
        $(document).one("user-data-updated", function (e, updatedData) {
            // Update the cells in the row
            $(cells[0]).text(updatedData.name);
            $(cells[1]).text(updatedData.idNumber);
            $(cells[2]).text(updatedData.title);
            $(cells[3]).text(updatedData.college);
            $(cells[4]).text(updatedData.schoolYear);
            $(cells[5]).text(updatedData.course);
            $(cells[6]).text(updatedData.email);
            $(cells[7]).text(updatedData.phone);
            $(cells[8]).text(updatedData.address);
            $(cells[9]).text(updatedData.birthDate);
            $(cells[10]).text(updatedData.sex);

            // Redraw the table to ensure all DataTables features work correctly
            table.rows($row).invalidate().draw(false);
        });
    },
};
