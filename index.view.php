<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>
</head>
<body>
    <?php foreach ($admins as $admin): ?>
        <p> <?php echo $admin->name ?> </p>
    <?php endforeach; ?>
</body>
</html>