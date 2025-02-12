<?php require_once "./app/app.php"; ?>
<?php require_once "./modules/products.php"; ?>

<?php
$products = new Product();
$listing = $products->listing();

if (request()->get("id")) {
    $data = $products->delete(request()->get("id"));
    request()->redirect("products.php");

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Products</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body class="bg-black">
    <!-- Navbar -->
    <?php component("navbar"); ?>
    <!-- Navbar -->
    <!-- Content -->
    <main class="boxed">
        <article class="card card-shadowless card-borderless">
            <div class="card-head">
                <h3 class="card-title">Products</h3>
                <a href="product-create.php" class="btn btn-dark">
                    Create
                </a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Active</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($listing) : ?>
                            <?php foreach ($listing as $item) : ?>
                                <tr>
                                    <td><?= $item["id"]; ?></td>
                                    <td><?= $item["name"]; ?></td>
                                    <td><?= $item["description"]; ?></td>
                                    <td><?= $item["quantity"]; ?></td>
                                    <td><?= $item["price"]; ?></td>
                                    <td><?= ($item['is_active']) ? 'Yes' : 'No'; ?></td>
                                    <td><?= date("F d, Y H:i A", strtotime($item["created_at"])); ?></td>
                                    <td><?= date("F d, Y H:i A", strtotime($item["updated_at"])); ?></td>
                                    <td>
                                        <a href="product-details.php?id=<?= $item["id"]; ?>" class="btn btn-light btn-sm">Details</a>
                                        <a href="product-update.php?id=<?= $item["id"]; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="products.php?id=<?= $item["id"]; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if (!$listing) : ?>
                    <div class="text-center">
                        <p><b>No records found!</b></p>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    </main>
    <!-- Content -->

    <!-- FOOTER -->
    <?php component("footer"); ?>
    <!-- FOOTER -->
    <!-- SCRIPTS -->
    <?php component("scripts"); ?>
    <!-- SCRIPTS -->
</body>

</html>