<?php


namespace controllers;
use components\AdminBase;

class AdminController extends AdminBase
{
    public function actionIndex() {
        self::checkAdmin();

        require_once __DIR__ . '/../views/admin/index.php';
        return true;
    }

}