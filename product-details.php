<?php require_once "./app/app.php"; ?>
<?php require_once "./modules/products.php"; ?>

<?php
$products = new Product();

if (request()->get("id")) {
    $data = $products->single(request()->get("id"));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Details</title>
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
    <!-- Content -->
    <main class="boxed">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-head">
                        <h3 class="card-title"><span class="bx bx-show"></span> Details </h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Name</td>
                                <td><?php echo $data["name"]; ?></td>
                            </tr>
                            <tr>
                                <td>description</td>
                                <td><?php echo $data["description"]; ?></td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td><?php echo $data["quantity"]; ?></td>
                            </tr>
                            <tr>
                                <td>Active</td>
                                <td><?= ($data['is_active']) ? 'Yes' : 'No'; ?></td>
                            </tr>
                            <tr>
                                <td>Created at</td>
                                <td><?= date("F d, Y H:i A", strtotime($data["created_at"])); ?></td>
                            </tr>
                            <tr>
                                <td>Updated at</td>
                                <td><?= date("F d, Y H:i A", strtotime($data["updated_at"])); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-foot">
                        <a href="products.php" class="btn btn-light">Go back</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <?php component("footer"); ?>
    <!-- FOOTER -->
    <!-- SCRIPTS -->
    <?php component("scripts"); ?>
    <!-- SCRIPTS -->
</body>

</html>