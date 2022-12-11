<?php
class Chat
{
    public $chatId;
    public $userId;
    public $msg;
    public $state;
    public $date;


    public function __construct($chatId, $userId,$msg,$state,$date)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->msg = $msg;
        $this->state = $state;
        $this->date = $date;

      
    }

   
}
