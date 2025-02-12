<?php require_once "./app/app.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>403</title>
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
    <main class="error-page">
        <section class="boxed">
            <div class="card card-msg">
                <div class="card-body">
                    <h2 class="card-title">403</h2>
                    <p class="card-subtitle">
                        Oops! It seems like you've taken a wrong turn. The page you're
                        looking for might have been moved, deleted, or it never existed in
                        the first place.
                    </p>
                </div>
                <button class="btn btn-dark-o" @click="() => window.history.back()">
                    Go back
                </button>
            </div>
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