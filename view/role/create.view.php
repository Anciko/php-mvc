<?php section('layout/header');?>

<div class="container">
        <div class="col-md-8 mx-auto">
            <form action="/roles" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>

                    <div class="mb-3 form-check">
                        <label class="form-label">Permissions</label>
                        <select class="form-select" name="permission_id[]" multiple>
                            <?php foreach ($permissions as $permission): ?>
                                <option value="<?php echo $permission->id; ?>"><?php echo $permission->name; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

<?php section('layout/footer');?>
