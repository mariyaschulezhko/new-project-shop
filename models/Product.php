<?php


namespace models;


use components\Db;

/**
 * Class Product
 * @package models
 */
class Product
{
    const SHOW_BY_DEFAULT = 2;


    /**
     * @param int $count
     * @return array
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        $db = Db::getConnection();

        $productsList = [];

        $result = $db->query('SELECT id, name, price, image, is_new FROM product WHERE status = "1" '
            . 'ORDER BY id DESC LIMIT ' . $count);
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }


    /**
     * @param false $categoryId
     * @param int $page
     * @return array
     */
    public static function getProductsListByCategory($categoryId = false, $page = 1)
    {
        if ($categoryId) {
            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
            $db = Db::getConnection();
            $products = [];

            $result = $db->query("SELECT id, name, price, image, is_new FROM product "
                . "WHERE status='1' AND category_id = '{$categoryId}' "
                . "ORDER BY id DESC "
                . "LIMIT " . self::SHOW_BY_DEFAULT
                . ' OFFSET ' . $offset);

            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }
            return $products;

        }
    }


    /**
     * @param $productId
     * @return mixed
     */
    public static function getProductById($productId)
    {
        $productId = intval($productId);

        if ($productId) {
            $db = Db::getConnection();
            $result = $db->query('SELECT * FROM product WHERE id = ' . $productId);
            $result->setFetchMode(\PDO::FETCH_ASSOC);
            $result->execute();
            return $result->fetch();
        }
    }


    /**
     * @param $categoryId
     * @return mixed
     */
    public static function getTotalProductsInCategory($categoryId)
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT count(id) AS count FROM product WHERE status = "1" AND category_id = "' . $categoryId . '"');
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    /**
     * @param $idsArray
     * @return array
     */
    public static function getProductByIds($idsArray)
    {
        $products = [];
        $db = Db::getConnection();
        $idsString = implode(',', $idsArray);
        $sql = "SELECT * FROM product WHERE status = '1' AND id IN ($idsString)";

        $result = $db->query($sql);
        $result->setFetchMode(\PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;

        }
        return $products;
    }

    /**
     * @return array
     */
    public static function getRecommendedProducts()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT id, name, price, is_new FROM product WHERE status = "1" AND is_recommended = "1" ORDER BY id DESC');

        $i = 0;
        $productList = [];
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;

    }


    /**
     * @return array
     */
    public static function getProductsList()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT id, name, price, code FROM product ORDER BY id ASC');
        $productsList = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['price'] = $row['price'];
            $i++;

        }
        return $productsList;
    }

    /**
     * @param $id
     * @return bool
     */
    public static function deleteProductById($id)
    {
        $db = Db::getConnection();

        $sql = "DELETE FROM product WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, \PDO::PARAM_INT);

        return $result->execute();



    }

    /**
     * @param $options
     * @return int|string
     */
    public static function createProduct($options)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO product '
            . '(name, code, price, category_id, brand, availability, '
            . 'description, is_new, is_recommended, status) '
            . 'VALUES '
            . '(:name, :code, :price, :category_id, :brand, :availability, '
            . ':description, :is_new, :is_recommended, :status) ';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], \PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], \PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], \PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], \PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], \PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], \PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], \PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], \PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], \PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], \PDO::PARAM_INT);

        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    /**
     * @param $id
     * @param $options
     * @return bool
     */
    public static function updateProductById($id, $options)
    {
        $db = Db::getConnection();
        $sql =  "UPDATE product
            SET 
                name = :name, 
                code = :code, 
                price = :price, 
                category_id = :category_id, 
                brand = :brand, 
                availability = :availability, 
                description = :description, 
                is_new = :is_new, 
                is_recommended = :is_recommended, 
                status = :status
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], \PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], \PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], \PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], \PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], \PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], \PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], \PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], \PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], \PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], \PDO::PARAM_INT);
        return $result->execute();


    }

    /**
     * @param $id
     * @return string
     */
    public static function getImage($id)
    {
        $noImage = 'no-Image.png';
        $path = '/upload/images/products/';

        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)){
            return $pathToProductImage;
    }
        return $path . $noImage;

}

}