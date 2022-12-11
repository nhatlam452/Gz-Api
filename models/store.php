<?php
class Store
{
    public $storeId;
    public $storeName;
    public $latitude;
    public $longitude;
    public $storeAddress;
    

    public function __construct($storeId, $storeName, $latitude,
                    $longitude,$storeAddress)
    {
        $this->storeId = $storeId;
        $this->storeName = $storeName;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->storeAddress = $storeAddress;
      
    }

  

}
