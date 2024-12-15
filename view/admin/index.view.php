<?php section('layout/header');?>

<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-between ">
                <h2 class="mb-0">All Admin Users ( <?php echo count($admins); ?>  )</h2>
                <a href="/admin-users/create" class="btn btn-danger ">Create New</a>
                </div>
                <hr>
                <?php foreach ($admins as $admin): ?>
                    <p> <?php echo $admin->name . " => " . $admin->email; ?> </p>
                    <div class="d-flex gap-2">
                        <a href="admin-users/<?php echo $admin->id; ?>/edit" class="btn btn-success">Edit</a>
                        <form action="/admin-users/<?php echo $admin->id; ?>/delete"
                        method="post">
                            <input type="hidden" name="id" value="<?php echo $admin->id; ?>">
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    <hr>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php section('layout/footer');?>