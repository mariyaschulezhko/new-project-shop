<?php


namespace controllers;


use models\Category;
use models\Product;
use models\User;

class SiteController
{
    public function actionIndex()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $latestProducts = [];
        $latestProducts = Product::getLatestProducts(3);

        $sliderProducts = Product::getRecommendedProducts();

        require_once __DIR__ . '/../views/site/index.php';

        return true;
    }

    public function actionViews()
    {

        return true;
    }


    public function actionContact()
    {
//        $mail = "mariyaschulezhko@gmail.com";
//        $subject = 'About';
//        $message = 'Content leter';
//        $result = mail($mail, $subject, $message);
//        var_dump($result);
//        die;

        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
            $errors = false;

            if (!User::checkEmail($userEmail)) {
                $errors[] = 'wrong email';
            }
            if ($errors === false) {
                $adminEmail = 'mariyaschulezhko@gmail.com';
                $message = "Text: {$userText}. user: {$userEmail}";
                $subject = 'about';
                $result = mail($adminEmail,$subject, $message);
                $result = true;
            }

        }
        require_once __DIR__ . '/../views/site/contact.php';
        return true;
    }

    public function actionAbout() {
        require_once __DIR__ . '/../views/site/about.php';
        return true;
    }

}