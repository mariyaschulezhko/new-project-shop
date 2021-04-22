<?php


namespace controllers;
use components\AdminBase;

/**
 * Class AdminController
 * @package controllers
 */
class AdminController extends AdminBase
{
    /**
     * @return bool
     */
    public function actionIndex() {
        self::checkAdmin();

        require_once __DIR__ . '/../views/admin/index.php';
        return true;
    }

}