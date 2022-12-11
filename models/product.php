<?php
class product
{
    public $productID;
    public $productName;
    public $price;
    public $url;
    public $description;
    public $available;
    public $quantity;
    public $discount;

    public function __construct($productID, $productName, $price,
                    $url,$discount,$description,$available,$quantity)
    {
        $this->productID = $productID;
        $this->productName = $productName;
        $this->price = $price;
        $this->url = $url;
        $this->discount = $discount;
        $this->description = $description;
        $this->available = $available;
        $this->quantity = $quantity;

    }

  

}
