<!-- Edit User Modal Component -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User: <span id="modalUserName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="userId" value="">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="idNumber" class="form-label">ID Number</label>
                            <input type="number" class="form-control" id="idNumber" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="title" class="form-label">Title</label>
                            <select class="form-control" id="title">
                                <option value="Assistant">Assistant</option>
                                <option value="Junior">Junior</option>
                                <option value="Senior">Senior</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="college" class="form-label">College</label>
                            <input type="text" class="form-control" id="college" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="schoolYear" class="form-label">School Year</label>
                            <input type="text" class="form-control" id="schoolYear" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="course" class="form-label">Course</label>
                            <input type="text" class="form-control" id="course" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="number" class="form-control" id="phone" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="sex" class="form-label">Sex</label>
                            <select class="form-control" id="sex">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="birthDate" class="form-label">Birth Date</label>
                            <input type="date" class="form-control" id="birthDate" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="saveUser">Save changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>