<?php


include_once '../controllers/product-controllers.php';



$response = null;

try {
    $fPrice = $_POST["fPrice"];
    $sPrice = $_POST["sPrice"];
    $bN = $_POST["brandName"];
    $order = $_POST["order"];
    $sortType = $_POST["sortType"];
    $response = (new ProductController())->getProductByPrice($fPrice, $sPrice, $bN,$order,$sortType);
} catch (Exception $ex) {
    $response = new Respone(4, true, "Server down" . $ex->getMessage(), null);
}

echo json_encode($response);
