<?php
require_once "./app/app.php";
require_once "./modules/products.php";

if (request()->get("create")) {
    $validate = validator()->validate($_POST, [
        'name' => 'required',
        'description' => 'required',
        'quantity' => 'required',
        'price' => 'required',
    ]);

    if (!$validate->fails()) {
        $id = request()->get("id");
        $product = new Product();
        $product->create(request()->only(["name", "price", "description", "quantity", "is_active"]));

        request()->redirect("products.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Product</title>
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
            <div class="col-sm-6">
                <form class="card card-borderless card-shadowless" method="post">
                    <div class="card-head">
                        <h3 class="card-title">Create</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-field">
                                <label class="field-label" for="name">Name</label>
                                <div class="field">
                                    <input class="field-text" name="name" required />
                                </div>
                            </div>
                            <div class="form-field">
                                <label class="field-label" for="description">Description</label>
                                <div class="field">
                                    <textarea class="field-textarea" name="description" id="description" required></textarea>
                                </div>
                            </div>
                            <div class="form-field">
                                <label class="field-label" for="price">Price</label>
                                <div class="field">
                                    <input class="field-text" name="price" required />
                                </div>
                            </div>
                            <div class="form-field">
                                <label class="field-label" for="quantity">Quantity</label>
                                <div class="field">
                                    <input type="number" class="field-text" name="quantity" required />
                                </div>
                            </div>
                            <div class="form-field">
                                <label class="field-label" for="is_active">Active</label>
                                <div class="field">
                                    <select name="is_active" class="field-select" required>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-foot">
                        <a href="products.php" class="btn btn-light">Go back</a>
                        <button class="btn btn-dark" name="create" value="create" type="submit">Create</button>
                    </div>
                </form>
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