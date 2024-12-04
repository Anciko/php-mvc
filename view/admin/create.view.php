<?php section('layout/header');?>

<div class="container">
        <div class="col-md-8 mx-auto">
            <form action="/admin-users" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                    </div>

                    <div class="mb-3 form-check">
                      <label class="form-label">Role</label>
                      <select class="form-select" name="role_id">
                          <option value="1">Super Admin</option>
                          <option value="2">Admin</option>
                          <option value="3">Account</option>
                      </select>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="other">Other</option>
                      </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select" name="is_active">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                      </select>
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

<?php section('layout/footer');?>
