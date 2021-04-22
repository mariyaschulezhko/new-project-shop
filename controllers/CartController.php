<?php


namespace controllers;


use components\Cart;
use models\Category;
use models\Order;
use models\Product;
use models\User;

/**
 * Class CartController
 * @package controllers
 */
class CartController
{
    /**
     * @param $id
     */
    public function actionAdd($id) {
        Cart::addProduct($id);

        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: {$referrer}");

    }

    /**
     * @param $id
     * @return bool
     */
    public function actionAddAjax($id)
    {
        echo Cart::addProduct($id);
        return true;
    }

    /**
     * @return bool
     */
    public function actionIndex() {
        $categories = [];
        $categories = Category::getCategoriesList();

        $productsInCart = Cart::getProducts();
       if ($productsInCart) {
           $productsIds = array_keys($productsInCart);
           $products = Product::getProductByIds($productsIds);

           $totalPrice = Cart::getTotalPrice($products);

       }
       require_once __DIR__ . '/../views/cart/index.php';
       return true;
    }

    /**
     * @return bool
     */
    public function actionCheckout()
    {
        $productsInCart = Cart::getProducts();

        if ($productsInCart == false) {
            header("Location: /");
        }

        $categories = Category::getCategoriesList();


        $productsIds = array_keys($productsInCart);
        $products = Product::getProductByIds($productsIds);
        $totalPrice = Cart::getTotalPrice($products);


        $totalQuantity = Cart::countItems();

        $userName = false;
        $userPhone = false;
        $userComment = false;

        $result = false;


        if (!User::isGuest()) {

            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else {

            $userId = false;
        }


        if (isset($_POST['submit'])) {

            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            $errors = false;


            if (!User::checkName($userName)) {
                $errors[] = 'Неправильное имя';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Неправильный телефон';
            }


            if ($errors == false) {

                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {

                    $adminEmail = 'mariiashulezhko58@gmail.com';
                    $message = 'NEW';
                    $subject = 'Новый заказ!';
                    mail($adminEmail, $subject, $message);


                    Cart::clear();
                }
            }
        }
        require_once __DIR__ . '/../views/cart/checkout.php';
        return true;

    }

    /**
     * @param $id
     */
    public function actionDelete($id) {
        Cart::deleteProduct($id);
        header("Location: /cart/");
    }


}