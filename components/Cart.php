<?php


namespace components;

/**
 * Class Cart
 * @package components
 */
class Cart
{
    /**
     * @param $id
     * @return int|mixed
     */
    public static function addProduct($id) {
        $id = intval($id);

        $productsInCart = [];

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id]++;
        } else {
            $productsInCart[$id] = 1;
        }
        $_SESSION['products'] = $productsInCart;
        return self::countItems();
    }

    /**
     * @return int|mixed
     */
    public static function countItems() {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;

            }
            return $count;
        } else {
            return 0;
        }
    }

    /**
     * @return false|mixed
     */
    public static function getProducts() {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    /**
     * @param $products
     * @return float|int
     */
    public static function getTotalPrice($products) {
        $productsInCart = self::getProducts();

        $total = 0;
        if ($productsInCart) {
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];

            }
        }
        return $total;
    }



    public static function clear() {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    /**
     * @param $id
     */
    public static function deleteProduct($id)
    {

        $productsInCart = self::getProducts();

        unset($productsInCart[$id]);

        $_SESSION['products'] = $productsInCart;
    }


}