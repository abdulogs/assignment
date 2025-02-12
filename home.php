<?php
require_once "./app/app.php";
require_once "./modules/auth.php";
middleware()->logout("id", "index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <!-- NAVBAR -->
    <?php component("navbar"); ?>
    <!-- NAVBAR -->
    <!-- CONTENT -->
    <main class="boxed">
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <div class="card card-borderless card-shadowless">
                    <div class="card-head">
                        <h3 class="card-subtitle">Welcome</h3>
                        <h3 class="card-title"><?=  auth()->user()["name"] ?? "N/A" ?></h3>
                    </div>
                    <div class="card-body">
                        <a href="products.php" class="btn btn-block btn-primary">View products</a>
                        <br>
                        <a href="logout.php" class="btn btn-block btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- CONTENT -->
    <!-- FOOTER -->
    <?php component("footer"); ?>
    <!-- FOOTER -->
    <!-- SCRIPTS -->
    <?php component("scripts"); ?>
    <!-- SCRIPTS -->
</body>

</html>