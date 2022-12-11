<?php

include_once '../configs/db-config.php';
include_once '../models/product.php';
include_once '../models/respone.php';
include_once '../models/brand.php';

include_once '../models/product-detail.php';
include_once '../models/images.php';

class ProductServices
{
    public $connect;
    public function __construct()
    {
        $this->connect = (new DBConfig())->getConnect();
    }
    public function getAllProducts()
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT TBLP.PRODUCTID ,PRODUCTNAME, PRICE,URL,
            IDEFAULT,TBPR.PROMOTIONID,DISCOUNT,description,available,quantity 
            FROM tblproduct TBLP
            INNER JOIN tblimages TBLM ON TBLP.PRODUCTID = TBLM.PRODUCTID 
            INNER JOIN tblpromotion TBPR ON TBLP.PROMOTIONID = TBPR.PROMOTIONID
            HAVING IDEFAULT = 1 ";

            $stmt = $this->connect->prepare($query);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listProduct = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $product = new Product($PRODUCTID, $PRODUCTNAME, $PRICE, $URL, $DISCOUNT
                , $description, $available, $quantity
            );
                array_push($listProduct, $product);
            }

            $response->setMessage("get all products success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listProduct);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function getAllBrand()
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT BRANDID,BRANDNAME FROM tblbrand ";

            $stmt = $this->connect->prepare($query);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listBrand = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $brand = new Brand($BRANDID, $BRANDNAME);
                array_push($listBrand, $brand);
            }

            $response->setMessage("get all brand success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listBrand);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function getProductByPrice($fPrice, $sPrice, $bN, $order, $sortType)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT TBLP.PRODUCTID ,PRODUCTNAME,description,available,quantity , PRICE,URL,IDEFAULT,TBPR.PROMOTIONID,DISCOUNT,TBBR.BRANDID,BRANDNAME FROM TBLPRODUCT TBLP
            INNER JOIN tblimages TBLM ON TBLP.PRODUCTID = TBLM.PRODUCTID 
            INNER JOIN tblpromotion TBPR ON TBLP.PROMOTIONID = TBPR.PROMOTIONID
            INNER JOIN tblbrand TBBR ON TBLP.BRANDID = TBBR.BRANDID
            HAVING IDEFAULT = 1 AND 
           ( PRICE BETWEEN  ? AND  ? OR ($fPrice IS NULL OR $sPrice IS NULL))
            AND  (BRANDNAME like $bN or $bN is null)
            order by $order $sortType 
            ";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $fPrice);
            $stmt->bindParam(2, $sPrice);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listProduct = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $product = new Product($PRODUCTID, $PRODUCTNAME, $PRICE, $URL, $DISCOUNT
                , $description, $available, $quantity
            );                array_push($listProduct, $product);
            }
            $response->setMessage("get all products success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listProduct);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function getProductDetail($productid)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT IMAGEID,URL FROM `tblimages` WHERE PRODUCTID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $productid);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listProduct = [];
            $listImages = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $images = new Images($IMAGEID, $URL);
                array_push($listImages, $images);
            }

            $query = "SELECT PRODUCTDETAILID,PRODUCTNAME,discount,PRICE,DESCRIPTION,TOP,NECK,BACK,FINGERBOARD,BRIDGE,ORIGIN,VIDEO
                FROM tblproductdetail inner join tblproduct 
                inner join tblpromotion
                WHERE tblproduct.PRODUCTID = $productid";
            $stmt = $this->connect->prepare($query);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch();
                extract($row);
                $productdetail = new ProductDetail(
                    $PRODUCTDETAILID,
                    $TOP,
                    $NECK,
                    $BACK,
                    $FINGERBOARD,
                    $BRIDGE,
                    $ORIGIN,
                    $listImages,
                    $VIDEO,
                    $PRODUCTNAME,
                    $DESCRIPTION,
                    $PRICE,
                    $discount
                

                );
                array_push($listProduct, $productdetail);
                $response->setMessage("GET PRODUCT DETAIL SUCCESS");
                $response->setError(false);
                $response->setResponeCode(1);
                $response->setData($listProduct);
            } else {
                $response->setMessage("can get image");
                $response->setError(true);
                $response->setResponeCode(2);
            }
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(false);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function deactiveProduct($productid)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "UPDATE tblproduct SET STATE = 0
            WHERE PRODUCTID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $productid);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Deactive product sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Deactive product failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }

    public function activeProduct($productid)
    {

        $respone = Respone::getDefaultInstance();
        try {
            $query = "UPDATE tblproduct SET STATE = 1
            WHERE PRODUCTID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $productid);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Active product sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Active product failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    // public function getProductsByString($string)
    // {
    //     $response = Respone::getDefaultInstance();
    //     try {
    //         $query = "SELECT TBLP.PRODUCTID ,PRODUCTNAME, PRICE, STATE,CATEGORYID,URL,IMAGEDEFAULT FROM TBLPRODUCT TBLP
    //         INNER JOIN TBLIMAGES TBLM ON TBLP.PRODUCTID = TBLM.PRODUCTID
    //         HAVING IMAGEDEFAULT = 0 AND PRODUCTNAME LIKE = '" % '?' % "'";
    //         $stmt = $this->connect->prepare($query);
    //         $stmt->bindParam(1, $string);
    //         $stmt->setFetchMode(PDO::FETCH_ASSOC);
    //         $stmt->execute();
    //         $listProduct = [];
    //         while ($row = $stmt->fetch()) {
    //             extract($row);
    //             $product = new Product($PRODUCTID, $PRODUCTNAME, $PRICE, $STATE, $CATEGORYID, $URL);
    //             array_push($listProduct, $product);
    //         }
    //         $response->setMessage("get products success");
    //         $response->setError(false);
    //         $response->setResponeCode(1);
    //         $response->setData($listProduct);
    //     } catch (Exception $ex) {
    //         $response->setMessage($ex->getMessage());
    //         $response->setError(true);
    //         $response->setResponeCode(0);
    //     }
    //     return $response;
    // }
    // public function getProductsByCategoryID($categoryid)
    // {

    //     $response = Respone::getDefaultInstance();
    //     try {
    //         $query = "SELECT TBLP.PRODUCTID ,PRODUCTNAME, PRICE, STATE,CATEGORYID,URL, IMAGEDEFAULT FROM TBLPRODUCT TBLP
    //         INNER JOIN TBLIMAGES TBLM ON TBLP.PRODUCTID = TBLM.PRODUCTID
    //         GROUP BY TBLP.PRODUCTID
    //         HAVING IMAGEDEFAULT = 1 AND TBLP.CATEGORYID = ?";

    //         $stmt = $this->connect->prepare($query);
    //         $stmt->bindParam(1, $categoryid);
    //         $stmt->setFetchMode(PDO::FETCH_ASSOC);
    //         $stmt->execute();
    //         $listProduct = [];
    //         while ($row = $stmt->fetch()) {
    //             extract($row);
    //             $product = new Product($PRODUCTID, $PRODUCTNAME, $PRICE, $STATE, $CATEGORYID, $URL);
    //             array_push($listProduct, $product);
    //         }
    //         $response->setMessage("get all products success");
    //         $response->setError(false);
    //         $response->setResponeCode(1);
    //         $response->setData($listProduct);
    //     } catch (Exception $ex) {
    //         $response->setMessage($ex->getMessage());
    //         $response->setError(true);
    //         $response->setResponeCode(0);
    //     }
    //     return $response;
    // }
    // public function insertProduct($data){
    //     $respone = Respone::getDefaultInstance();
    //     try {
    //         $query = "INSERT INTO TBLPRODUCT SET PRODUCTID = NULL, PRODUCTNAME = ?, PRICE = ?,
    //         QUANTITY =NULL, DESCRIPTION = ?,AVAILABLE =1, TYPEID = 1,PROMOTIONID=NULL";
    //         $stmt = $this->connect->prepare($query);
    //         $stmt->bindParam(1, $data->phoneNumber);
    //         $stmt->bindParam(2, $data->firstName);
    //         $stmt->bindParam(3, $data->lastName);
    //         $this->connect->beginTransaction();
    //         if ($stmt->execute()) {
    //             $query = "SELECT * FROM TBLPRODUCT WHERE PRODUCTNAME = ? ";
    //             $stmt = $this->connect->prepare($query);
    //             $stmt->bindParam(1, $data->phoneNumber);
    //             $stmt->execute();
    //             $this->connect->commit();
    //             $listProduct =[];
    //             if ($stmt->rowCount() > 0) {
    //                 $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //                 extract($row);
    //                 $product = new Product($PRODUCTID, $PRODUCTNAME, $PRICE,$DESCRIPTION);
    //                 array_push($listProduct, $product);
    //                 $respone->setMessage("get all products success");
    //                 $respone->setError(false);
    //                 $respone->setResponeCode(1);
    //                 $respone->setData($listProduct);
    //             } else {
    //                 $this->connect->rollBack();
    //                 $respone->setError(true);
    //                 $respone->setResponeCode(2);
    //                 $respone->setMessage("Insert address failed");
    //             }
    //         } else {
    //             $this->connect->rollBack();
    //             $respone->setError(true);
    //             $respone->setResponeCode(2);
    //             $respone->setMessage("Insert user failed");
    //         }
    //     } catch (Exception $ex) {
    //         $respone->setMessage("Cann't read query" . $ex->getMessage());
    //         $respone->setError(true);
    //         $respone->setResponeCode(7);
    //     }
    //     return $respone;
    // }
    public function getImagesByProductID($productid)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT IMAGEID,PRODUCTID, URL FROM tblimages WHERE PRODUCTID =?";

            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $productid);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listImages = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $images = new Images($IMAGEID, $URL, $PRODUCTID);
                array_push($listImages, $images);
            }
            $response->setMessage("get images success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listImages);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(false);
            $response->setResponeCode(0);
        }
        return $response;
    }
}
