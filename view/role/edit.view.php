<?php section('layout/header');?>

<div class="container">
        <div class="col-md-8 mx-auto">
            <form action="/roles/<?php echo $role['id'] ?>/update" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $role['name'] ?>" id="name">
                    </div>

                    <div class="mb-3 form-check">
                        <label class="form-label">Permissions</label>
                        <select class="form-select" name="permission_id[]" multiple>
                            <?php foreach ($permissions as $permission): ?>
                                <option value="<?php echo $permission->id; ?>" 
                                    <?php 
                                        if(in_array($permission->id, $old_permissions)) {
                                            echo "selected";
                                        }
                                    ?>
                                >
                                    <?php echo $permission->name; ?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

<?php section('layout/footer');?>
