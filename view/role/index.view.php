<?php section('layout/header');?>

<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-between ">
                <h2 class="mb-0">All Roles ( <?php echo count($roles); ?>  )</h2>
                <?php if (CheckUserPermission::has('create_role')): ?>
                    <a href="/roles/create" class="btn btn-danger ">Create New</a>
                <?php endif;?>
                </div>
                <hr>
                <?php foreach ($roles as $role): ?>
                    <p> <?php echo $role['name']; ?> </p>
                    <div class="mb-2">
                        <?php foreach ($role['permissions'] as $permission): ?>
                            <span class="badge bg-dark"> <?php echo $permission->name; ?> </span>
                        <?php endforeach;?>
                    </div>
                    <div class="d-flex gap-2">
                    <?php if (CheckUserPermission::has('update_role')): ?>
                            <a href="roles/<?php echo $role['id']; ?>/edit" class="btn btn-success">Edit</a>
                    <?php endif;?>

                    <?php if (CheckUserPermission::has('delete_role')): ?>
                        <form action="/roles/<?php echo $role['id']; ?>/delete"
                        method="post">
                            <input type="hidden" name="id" value="<?php echo $role['id']; ?>">
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    <?php endif; ?>
                    </div>
                    <hr>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php section('layout/footer');?>