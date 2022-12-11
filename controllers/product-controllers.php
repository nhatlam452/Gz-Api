<?php
include_once '../services/product-services.php';
class ProductController
{
    private $services;
    public function __construct()
    {
        $this->services = new ProductServices();
    }
    public function getAllProducts()
    {
        return $this->services->getAllProducts();
    }
    public function getAllBrand()
    {
        return $this->services->getAllBrand();
    }
    public function getProductByPrice($fPrice, $sPrice, $bN,$order,$sortType)
    {
        return $this->services->getProductByPrice($fPrice, $sPrice, $bN,$order,$sortType);
    }
    public function getProductDetail($productid)
    {
        return $this->services->getProductDetail($productid);
    }
    // public function insertProduct($data)
    // {
    //     return $this->services->insertProduct($data);
    // }
    public function deactiveProduct($productid)
    {
        return $this->services->deactiveProduct($productid);
    }
    public function activeProduct($productid)
    {
        return $this->services->activeProduct($productid);
    }
    public function getProductsByCategoryID($categoryid)
    {
        return $this->services->getProductsByCategoryID($categoryid);
    }
    public function getImagesByProductID($productid)
    {
        return $this->services->getImagesByProductID($productid);
    }
}
