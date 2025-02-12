<?php require_once "./app/app.php";
require_once "./modules/auth.php";

middleware()->login("id","home.php");

if (request()->get("signup")) {
    $validate = validator()->validate($_POST, [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:4',
    ]);

    if (!$validate->fails()) {
        auth()->signup(
            [
                "name" => request()->get("name"),
                "email" => request()->get("email"),
                "password" => password_hash(request()->get("password"), PASSWORD_BCRYPT),
            ]
        );
        session()->flash("success", "Account created successfully now you can login");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <?php component("navbar"); ?>
    <!-- Navbar -->
    <main class="account-page">
        <section class="boxed">
            <div class="col-12 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4">
                <form method="POST" autocomplete="on" class="card card-login">
                    <div class="card-head">
                        <h1 class="card-title">Signup</h1>
                        <p class="card-desc">
                            Already have an account? <a href="index.php" class="link link-primary">Login</a>
                        </p>
                    </div>
                    <div class="card-body">
                        <span class="field-success-text"><?= session()->message("success"); ?></span>

                        <?= csrf()->field(); ?>
                        <div class="form-field">
                            <label for="name" class="field-label required">Name</label>
                            <div class="field">
                                <input type="name" class="field-text" name="name" id="name" value="<?= request()->get("name"); ?>" />
                            </div>
                            <?php if (IsError("name")): ?>
                                <span class="field-error-text"><?= error("name"); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-field">
                            <label for="email" class="field-label required">Email address</label>
                            <div class="field">
                                <input type="email" class="field-text" name="email" id="email" value="<?= request()->get("email"); ?>" />
                            </div>
                            <?php if (IsError("email")): ?>
                                <span class="field-error-text"><?= error("email"); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-field">
                            <label for="password" class="field-label required">Password</label>
                            <div class="field" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" class="field-text" id="password"
                                    name="password" />
                                <button type="button" class="field-append-text" @click="show = !show">
                                    <span class="bx" :class="show == false ? 'bx-show' : 'bx-hide'"></span>
                                </button>
                            </div>
                            <?php if (IsError("password")): ?>
                                <span class="field-error-text"><?= error("password"); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-foot">
                        <button type="submit" name="signup" value="signup" class="btn btn-primary btn-block">Signup</button>
                    </div>
                </form>
            </div>

        </section>
    </main>
    <!-- FOOTER -->
    <?php component("footer"); ?>
    <!-- FOOTER -->
    <!-- SCRIPTS -->
    <?php component("scripts"); ?>
    <!-- SCRIPTS -->

    <?php flush_errors(); ?>

</body>

</html>