<?php


namespace controllers;


use models\User;

/**
 * Class UserController
 * @package controllers
 */
class UserController
{
    /**
     * @return bool
     */
    public function actionRegister()
    {
        $name = '';
        $email ='';
        $password = '';
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            if(!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов ';
            }

            if(!User::checkEmail($email)) {
                $errors[] = 'Не правильный email';
            }

            if(!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов ';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if ($errors === false) {
                $result = User::register($name, $email, $password);
            }
        }

        require_once __DIR__ . '/../views/user/register.php';
        return true;
    }

    /**
     * @return bool
     */
    public function actionLogin()
    {
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;
            if (!User::checkEmail($email) || !User::checkPassword($password)) {
                $errors[] = 'Неправильный email или пароль';
            }

            $userId = User::checkUserDate($email, $password);

            if ($userId === false) {
                $errors[] = 'Неправильные данные для входа в личный кабинет';
            } else {
                User::auth($userId);

                header('Location: /cabinet/');
            }

        }
           require_once __DIR__ . '/../views/user/login.php';
        return true;
    }


    public function actionLogout()
    {

        unset($_SESSION['user']);
        header('Location: /');

    }

}