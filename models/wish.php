<?php
class Wish
{
    public $wishid;
    public $phonenumber;
    public $productid;
    public $productname;

    public function __construct($wishid, $phonenumber, $productid, $productname)
    {
        $this->wishid = $wishid;
        $this->phonenumber = $phonenumber;
        $this->productid = $productid;
        $this->productname = $productname;
    }

    /**
     * Get the value of wishid
     */
    public function getWishid()
    {
        return $this->wishid;
    }

    /**
     * Set the value of wishid
     */
    public function setWishid($wishid): self
    {
        $this->wishid = $wishid;

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
}
