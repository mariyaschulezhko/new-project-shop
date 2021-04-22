<?php


namespace controllers;
use components\AdminBase;
use models\Order;
use models\Product;


/**
 * Class AdminOrderController
 * @package controllers
 */
class AdminOrderController extends AdminBase
{
    public function actionIndex() {
        self::checkAdmin();

        $ordersList = Order::getOrdersList();


        require_once __DIR__ . '/../views/admin_order/index.php';
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionView($id) {
        self::checkAdmin();

        $order = Order::getOrderById($id);

        $productsQuantity = json_decode($order['products'], true);
        $productsIds = array_keys($productsQuantity);
        $products = Product::getProductByIds($productsIds);

        require_once __DIR__ . '/../views/admin_order/view.php';
        return true;
    }


    /**
     * @param $id
     * @return bool
     */
    public function actionDelete($id) {
        self::checkAdmin();

        if (isset($_POST['submit'])) {
            Order::deleteOrderById($id);
            header('Location: /admin/order');
        }

        require_once __DIR__ . '/../views/admin_order/delete.php';
        return true;
    }


    /**
     * @param $id
     * @return bool
     */
    public function actionUpdate($id) {
        self::checkAdmin();
        $order = Order::getOrderById($id);

        if(isset($_POST['submit'])) {
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            $order = Order::updateOrderById($id, $userName, $userPhone, $userComment, $date, $status);
            header("Location: /admin/order/view/{$id}");
        }

        require_once __DIR__ . '/../views/admin_order/update.php';
        return true;
    }

}