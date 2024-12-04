<?php
session_start();
if (isset($_SESSION['auth_user'])) {
    redirectRoute('/');
}
?>


<?php
require_once  __DIR__ . "/../layout/header.view.php";
?>

   <div class="container">
        <div class="col-md-6 mx-auto">
        <h1>Login</h1>
            <form method="post" action="/login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
   </div>


<?php
require_once __DIR__ . "/../layout/footer.view.php";
?>
