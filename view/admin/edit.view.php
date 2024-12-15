<?php section('layout/header');?>

<div class="container">
        <div class="col-md-8 mx-auto">
            <?php if($admin): ?>
            <form action="/admin-users/<?php echo $admin->id ?>/update" method="POST">
            <div>
                        <input type="text" hidden
                            value="<?php echo $admin->id; ?>"
                            name="id" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text"  
                        value="<?php echo $admin->name; ?>"
                        name="name" class="form-control" id="name">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" 
                        value="<?php echo $admin->username; ?>"
                         name="username" class="form-control" id="username">
                    </div>

                    <div class="mb-3 form-check">
                      <label class="form-label">Role</label>
                      <select class="form-select" name="role_id">
                        <?php foreach([1,2,3] as $role): ?>
                            <option value="<?php echo $role; ?>"
                                <?php 
                                    if ($role == $admin->role_id) {
                                       echo "selected";
                                    }
                                ?>
                            >
                                <?php echo $role; ?>
                            </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" 
                        value="<?php echo $admin->phone;  ?>"
                        name="phone" class="form-control" id="phone">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                        value="<?php echo $admin->email;  ?>"
                        name="email" class="form-control" id="email">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" 
                        value="<?php echo $admin->address;  ?>"
                        name="address" class="form-control" id="address">
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                        <?php foreach(['male', 'female'] as $gender): ?>
                            <option value="<?php echo $gender; ?>"
                                <?php 
                                    if ($gender == $admin->gender) {
                                       echo "selected";
                                    }
                                ?>
                            >
                                <?php echo ucfirst($gender); ?>
                            </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select" name="is_active">
                            <?php foreach([1, 0] as $is_active): ?>
                                <option value="<?php echo $is_active; ?>"
                                    <?php 
                                        if ($is_active == $admin->is_active) {
                                        echo "selected";
                                        }
                                    ?>
                                >
                                    <?php echo ucfirst($is_active); ?>
                                </option>
                            <?php endforeach; ?>
                      </select>
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <?php endif; ?>
        </div>
</div>

<?php section('layout/footer');?>
