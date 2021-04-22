<?php


namespace controllers;


use components\Cart;
use models\Category;
use models\Order;
use models\Product;
use models\User;

class CartController
{
    public function actionAdd($id) {
        Cart::addProduct($id);

        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: {$referrer}");

    }

    public function actionAddAjax($id)
    {
        echo Cart::addProduct($id);
        return true;
    }

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

    public function actionCheckout()
    {
        // Получием данные из корзины
        $productsInCart = Cart::getProducts();

        // Если товаров нет, отправляем пользователи искать товары на главную
        if ($productsInCart == false) {
            header("Location: /");
        }

        // Список категорий для левого меню
        $categories = Category::getCategoriesList();

        // Находим общую стоимость
        $productsIds = array_keys($productsInCart);
        $products = Product::getProductByIds($productsIds);
        $totalPrice = Cart::getTotalPrice($products);


        // Количество товаров
        $totalQuantity = Cart::countItems();

        // Поля для формы
        $userName = false;
        $userPhone = false;
        $userComment = false;

        // Статус успешного оформления заказа
        $result = false;

        // Проверяем является ли пользователь гостем
        if (!User::isGuest()) {
            // Если пользователь не гость
            // Получаем информацию о пользователе из БД
            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else {
            // Если гость, поля формы останутся пустыми
            $userId = false;
        }

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkName($userName)) {
                $errors[] = 'Неправильное имя';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Неправильный телефон';
            }


            if ($errors == false) {
                // Если ошибок нет
                // Сохраняем заказ в базе данных
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    // Если заказ успешно сохранен
                    // Оповещаем администратора о новом заказе по почте
                    $adminEmail = 'mariiashulezhko58@gmail.com';
                    $message = 'NEW';
                    $subject = 'Новый заказ!';
                    mail($adminEmail, $subject, $message);

                    // Очищаем корзину
                    Cart::clear();
                }
            }
        }
        require_once __DIR__ . '/../views/cart/checkout.php';
        return true;

    }

    public function actionDelete($id) {
        Cart::deleteProduct($id);
        header("Location: /cart/");
    }


}