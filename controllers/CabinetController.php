<?php


namespace controllers;


use models\User;

/**
 * Class CabinetController
 * @package controllers
 */
class CabinetController
{
    /**
     * @return bool
     */
    public function actionIndex()
    {
        $userId = User::checkLogged();

        $user = User::getUserById($userId);
        require_once __DIR__ . '/../views/cabinet/index.php';
        return true;
    }

    /**
     * @return bool
     */
    public function actionEdit() {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);

        $name = $user['name'];
        $password = $user['password'];

        $result = false;

        if (isset($_POST['submit'])){
            $name = $_POST['name'];
            $password = $_POST['password'];
            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'name must be longer when 2 sing';
            }

            if(!User::checkPassword($password)) {
                $errors[] = 'password must be longer 5 sing';
            }

            if($errors === false) {
                $result = User::edit($userId, $name, $password);
            }
        }
        require_once __DIR__ . '/../views/cabinet/edit.php';
        return true;

    }


}