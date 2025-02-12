<?php require_once "./app/app.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>404</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body class="error-page">
    <!-- Navbar -->
    <?php component("navbar"); ?>
    <!-- Navbar -->

    <main class="boxed">
        <section class="card card-error">
            <div class="card-image">
                <img src="{{ asset('images/404.webp') }}" alt="404" class="image">
            </div>
            <div class="card-body">
                <h2 class="card-title">Page Not Found</h2>
                <p class="card-subtitle">
                    Oops! It seems like you've taken a wrong turn. The page you're
                    looking for might have been moved, deleted, or it never existed in
                    the first place.
                </p>
            </div>
            <button class="btn btn-dark-o" @click="window.history.back()">
                Go back
            </button>
        </section>
    </main>
    <!-- FOOTER -->
    <?php component("footer"); ?>
    <!-- FOOTER -->
    <!-- SCRIPTS -->
    <?php component("scripts"); ?>
    <!-- SCRIPTS -->
</body>

</html>