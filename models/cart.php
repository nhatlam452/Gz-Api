<?php
class Cart
{
    public $cartId;
    public $userId;
    public $productId;
    public $productName;
    public $quantity;
    public $url;
    public $price;
    public $discount;




    public function __construct($cartId, $userId, $productId, $productName, $quantity, $url, $price,$discount)
    {
        $this->cartId = $cartId;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->url = $url;
        $this->price = $price;
        $this->discount = $discount;

    }
    /**
     * Get the value of cartid
     */
    public function getCartid()
    {
        return $this->cartid;
    }

    /**
     * Set the value of cartid
     */
    public function setCartid($cartid): self
    {
        $this->cartid = $cartid;

        return $this;
    }

    /**
     * Get the value of phonenumber
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set the value of phonenumber
     */
    public function setPhonenumber($phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get the value of productid
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * Set the value of productid
     */
    public function setProductid($productid): self
    {
        $this->productid = $productid;

        return $this;
    }

    /**
     * Get the value of productname
     */
    public function getProductname()
    {
        return $this->productname;
    }

    /**
     * Set the value of productname
     */
    public function setProductname($productname): self
    {
        $this->productname = $productname;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     */
    public function setQuantity($quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
