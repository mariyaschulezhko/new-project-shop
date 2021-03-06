<?php


namespace controllers;
use components\AdminBase;
use models\Category;

/**
 * Class AdminCategoryController
 * @package controllers
 */
class AdminCategoryController extends AdminBase
{
    /**
     * @return bool
     */
public function actionIndex() {
    self::checkAdmin();
    $categoriesList = Category::getCategoriesListAdmin();

    require_once __DIR__ . '/../views/admin_category/index.php';
    return true;
}

    /**
     * @return bool
     */
public function actionCreate() {
    self::checkAdmin();

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $sortOrder = $_POST['sort_order'];
        $status = $_POST['status'];

        $errors = false;

        if (!isset($name) || empty($name)) {
            $errors[] = 'Заполните поля';
        }

        if ($errors === false) {
            Category::createCategory($name, $sortOrder, $status);

            header("Location: /admin/category");
        }
    }
    require_once __DIR__ . '/../views/admin_category/create.php';
    return true;
}

    /**
     * @param $id
     * @return bool
     */
public function actionUpdate($id) {
    self::checkAdmin();


    $category = Category::getCategoryById($id);


    if (isset($_POST['submit'])) {

        $name = $_POST['name'];
        $sortOrder = $_POST['sort_order'];
        $status = $_POST['status'];


        Category::updateCategoryById($id, $name, $sortOrder, $status);


        header("Location: /admin/category");
    }


    require_once __DIR__ . '/../views/admin_category/update.php';
    return true;
}

    /**
     * @param $id
     * @return bool
     */
    public function actionDelete($id)
    {
        self::checkAdmin();


        if (isset($_POST['submit'])) {

            Category::deleteCategoryById($id);

            header("Location: /admin/category");
        }


        require_once __DIR__ . '/../views/admin_category/delete.php';
        return true;
    }

}