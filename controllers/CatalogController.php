<?php


namespace controllers;


use components\Pagination;
use models\Category;
use models\Product;

/**
 * Class CatalogController
 * @package controllers
 */
class CatalogController
{
    /**
     * @return bool
     */
    public function actionIndex()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $latestProducts = [];
        $latestProducts = Product::getLatestProducts(15);

        require_once __DIR__ . '/../views/catalog/index.php';
        return true;
    }

    /**
     * @param $categoryId
     * @param int $page
     * @return bool
     */
    public function actionCategory($categoryId, $page = 1)
    {
        $categories = [];

        $categories = Category::getCategoriesList();

        $categoryProducts = [];

        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);

        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');


        require_once __DIR__ . '/../views/catalog/category.php';
        return true;

    }

}