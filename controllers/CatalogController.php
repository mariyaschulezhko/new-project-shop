<?php


namespace controllers;


use components\Pagination;
use models\Category;
use models\Product;

class CatalogController
{
    public function actionIndex()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $latestProducts = [];
        $latestProducts = Product::getLatestProducts(15);

        require_once __DIR__ . '/../views/catalog/index.php';
        return true;
    }

    public function actionCategory($categoryId, $page = 1)
    {
        $categories = [];

        $categories = Category::getCategoriesList();

        $categoryProducts = [];

        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        // Общее количетсво товаров (необходимо для постраничной навигации)
        $total = Product::getTotalProductsInCategory($categoryId);

        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');


        require_once __DIR__ . '/../views/catalog/category.php';
        return true;

    }

}