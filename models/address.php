<?php
class Address
{
    public $addressId;
    public $address;
    public $ward;
    public $district;
    public $city;
    public $userId;
    public $addressName;

    public function __construct($addressId, $address,$ward,$district,$city, $userId, $addressName)
    {
        $this->addressId = $addressId;
        $this->address = $address;
        $this->ward = $ward;
        $this->district = $district;
        $this->city = $city;
        $this->userId = $userId;
        $this->addressName = $addressName;
    }

   
}
