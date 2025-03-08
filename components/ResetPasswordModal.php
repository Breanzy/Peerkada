<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="confirmationSection">
                    <p>Enter a new password for <strong id="resetUserName"></strong>:</p>
                    <div class="form-group mb-3">
                        <label for="inputNewPassword">New Password</label>
                        <input type="password" class="form-control" id="inputNewPassword" required>
                        <div class="invalid-feedback">Please enter a new password.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirmNewPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmNewPassword" required>
                        <div class="invalid-feedback">Passwords don't match.</div>
                    </div>
                </div>
                <div id="resultSection" style="display: none;">
                    <div class="alert alert-success">
                        <p>Password has been successfully reset!</p>
                        <p>The new password has been set.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmResetBtn">Reset Password</button>
                <button type="button" class="btn btn-success" id="doneResetBtn" style="display: none;" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>