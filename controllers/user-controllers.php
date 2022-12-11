<?php
include_once '../services/user-services.php';
include_once '../services/product-services.php';

class UserController
{
    private $services;
    public function __construct()
    {
        $this->services = new UserServices();
    }

    public function checkUserExits($phoneNumber)
    {
        return $this->services->checkUserExits($phoneNumber);
    }
    public function getUserByUsername($userId)
    {
        return $this->services->getUserByUsername($userId);
    }
    public function getPasswordByPhoneNumber($phoneNumber)
    {
        $this->services->getPasswordByPhoneNumber($phoneNumber);
    }
    public function updateUserPassword($phoneNumber,$newPassword,$password)
    {
        if($password == null){
            return $this->services->updateUserPassword($phoneNumber, $newPassword);
        }else{
            $respone = $this->services->getPasswordByPhoneNumber($phoneNumber);
            if ($respone->getError() === false) {
                if ($respone->getData() !== null) {
                    if (strcmp($password, $respone->getData()[0]->getPassword()) == 0) {
                        $respone = $this->services->updateUserPassword($phoneNumber, $newPassword);
                    } else {
                        $respone->setResponeCode(0);
                        $respone->setMessage("Your old password does not matched ");
                        $respone->getData()[0]->setPassword(null);
                    }
                } else {
                    $respone->setResponeCode(2);
                    $respone->setMessage("Wrong Phone number");
                }
            }
            return $respone;
        }
        
    }
    public function forgotPassword($phoneNumber, $newPassword)
    {
        return $this->services->updateUserPassword($phoneNumber, $newPassword);
    }
    public function registerByFb($data)
    {
         $this->services->registerByFb($data);
    }

    public function checkFbIdExits($fbId){
        $this->services->checkFbIdExits($fbId);
    }
    public function getUserByFbId($fbId){
        $this->services->getUserByFBID($fbId);

    }
    public function socicalLogin($data){
        $respone = $this->services->checkFbIdExits($data->fbId);
        if($respone->getError() === false){
            if($respone ->getResponeCode() == 2){
                $respone = $this->services->registerByFb($data);
                $respone->setError(true);
            }else{
                $respone = $this->services->getUserByFbId($data->fbId);
                $respone->setError(true);
            }
        }else{
            $respone->setResponeCode(5);
            $respone->setError(true);
            $respone->setMessage("Server's bad");
        }
        return $respone;
    }
    
    public function checkLogin($phoneNumber, $password)
    {
        $respone = $this->services->getPasswordByPhoneNumber($phoneNumber);
        if ($respone->getError() === false) {
            if ($respone->getData() !== null) {
                if (strcmp($password, $respone->getData()[0]->getPassword()) == 0) {
                   $respone = $this->services->getUserByUsername($respone->getData()[0]->getUserId());       
                } else {
                    $respone->setResponeCode(0);
                    $respone->setMessage("Wrong Password or Phone Number");
                    $respone->getData(null);
                }
            } else {
                $respone->setResponeCode(2);
                $respone->setMessage("Wrong Password or Phone Number");
            }
        } else {
            $respone->setResponeCode(5);
            $respone->setMessage("Server's bad");
        }
        return $respone;
    }
    public function insertUser($data)
    {
        return $this->services->insertUser($data);
    }
    public function insertComment($data)
    {
        return $this->services->insertComment($data);
    }

    public function getCartByPhonenumber($userId)
    {
        return $this->services->getCartByPhonenumber($userId);
    }
    public function addToCart($userId,$productId,$quantity)
    {
        return $this->services->addToCart($userId,$productId,$quantity);
    }
    public function updateUser($param,$value,$userId)
    {
        return $this->services->updateUser($param,$value,$userId);
    }
    public function removeCart($cartid)
    {
        return $this->services->removeCart($cartid);
    }
    public function getAllAddress($userId)
    {
        return $this->services->getAllAddress($userId);
    }
    public function getAllComment($productId)
    {
        return $this->services->getAllComment($productId);
    }
    public function insertAddress($data)
    {
        return $this->services->insertAddress($data);
    }
    public function updateAddress($data)
    {
        return $this->services->updateAddress($data);
    }
    public function setDefaultAddress($data)
    {
        return $this->services->setDefaultAddress($data);
    }
    public function setUnDefaultAddress($data)
    {
        return $this->services->setUnDefaultAddress($data);
    }
    public function inserOrder($data)
    {
        return $this->services->inserOrder($data);
    }
    public function getOrderByPhoneNumber($userId)
    {
        return $this->services->getOrderByPhoneNumber($userId);
    }
    public function insertOrderDetail($data)
    {
        return $this->services->insertOrderDetail($data);
    }
    public function getOrderDetail($orderid)
    {
        return $this->services->getOrderDetail($orderid);
    }
    public function getAllNews()
    {
        return $this->services->getAllNews();
    }
    public function getAllStore()
    {
        return $this->services->getAllStore();
    }
}
