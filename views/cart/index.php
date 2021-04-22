<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Catalog</h2>
                    <div class="panel-group category-products">
                        <?php foreach ($categories as $categoryItem): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="/category/<?= $categoryItem['id']; ?>">
                                        <?= $categoryItem['name']; ?>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Cart</h2>


                    <?php if ($productsInCart): ?>
                    <p>Your Cart:</p>
                    <table class="table-bordered table-striped table">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Price $</th>
                            <th>Quantity</th>
                            <th>Удалить</th>
                        </tr>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['code']; ?></td>
                            <td>
                                <a href="/product/<?= $product['id']; ?>">
                                    <?= $product['name']; ?>
                                </a>
                            </td>
                            <td><?=$product['price']; ?></td>
                            <td><?= $productsInCart[$product['id']]; ?></td>
                            <td>
                                <a href="/cart/delete/<?php echo $product['id'];?>">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4">Total:</td>
                            <td><?= $totalPrice; ?></td>
                        </tr>
                    </table>


                    <a class="btn btn-default checkout" href="/cart/checkout"><i class="fa fa-shopping-cart"></i> Оформить заказ</a>
                    <?php else: ?>
                    <p>Корзина пуста</p>

                    <a class="btn btn-default checkout" href="/"><i class="fa fa-shopping-cart"></i> Вернуться к покупкам</a>
                    <?php endif; ?>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</section>




<?php
require_once __DIR__ . '/../layouts/footer.php';
?>

