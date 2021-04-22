<?php


namespace controllers;


use models\Category;
use models\Product;

/**
 * Class ProductController
 * @package controllers
 */
class ProductController
{
    /**
     * @param $productId
     * @return bool
     */
    public function actionView($productId)
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $product = Product::getProductById($productId);
        require __DIR__ . '/../views/product/view.php';
        return true;
    }

}