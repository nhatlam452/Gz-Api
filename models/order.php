<?php
class Order
{
    public $orderId;
    public $userId;
    public $status;
    public $total;
    public $note;
    public $createDate;
    public $orderMethod;
    public $dFrom;
    public $dTo;
    public $paymentMethod;
    public $listCart;

    

    public function __construct($orderId, $userId, 
    $status, $total,$note, $createDate,
    $orderMethod,$dFrom,$dTo,$paymentMethod)
    {
        $this->orderId = $orderId;
        $this->userId = $userId;
        $this->status = $status;
        $this->total = $total;
        $this->note = $note;
        $this->createDate = $createDate;
        $this->orderMethod = $orderMethod;
        $this->dFrom = $dFrom;
        $this->dTo = $dTo;
        $this->paymentMethod = $paymentMethod;


        


    }

   
}
