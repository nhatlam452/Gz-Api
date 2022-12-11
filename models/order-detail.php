<?php
class OrderDetail
{
    public $orderDetailId;
    public $productName;
    public $url;
    public $quantity;
    public $orderId;
    public $productId;

    public function __construct($orderDetailId, $productName, $quantity,$url, $orderId, $productId)
    {
        $this->orderDetailId = $orderDetailId;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->url = $url;

        $this->orderId = $orderId;
        $this->productId = $productId;
    }
}
