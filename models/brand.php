<?php
class Brand
{
    public $brandId;
    public $brandName;


    public function __construct($brandId, $brandName)
    {
        $this->brandId = $brandId;
        $this->brandName = $brandName;
      
    }

   
}
