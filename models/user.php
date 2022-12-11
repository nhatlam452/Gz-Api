<?php
class User 
{   

    public $userId;
    public $phoneNumber;
    public $fbId;
    public $email;
    public $avatar;
    public $firstName;
    public $lastName;
    public $password;
    public $dob;
    public $salutation;
    public $notification;
    public $role;
    
    
    public function __construct($userId, $phoneNumber, $fbId,$email,$avatar,$firstName,$lastName, 
    $password, $dob,$salutation, $notification, $role)
    {
        $this->userId = $userId;
        $this->phoneNumber = $phoneNumber;
        $this->fbId = $fbId;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->dob = $dob;
        $this->salutation = $salutation;
        $this->notification = $notification;
        $this->role = $role;
    }
     public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     */
    public function setUserId($userId): self
    {
        $this->userId = $userId;

        return $this;
    }

}
