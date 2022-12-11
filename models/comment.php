<?php
class Comment
{
    public $commentId;
    public $userId;
    public $productId;
    public $content;
    public $date;
    public $img;
    public $status;
    public $avatar;
    public $name;


    public function __construct($commentId, $userId,$productId,$content,$date, $img,$status,$avatar,$name )
    {
        $this->commentId = $commentId;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->content = $content;
        $this->date = $date;
        $this->img = $img;
        $this->status = $status;
        $this->avatar = $avatar;
        $this->name = $name;



    }

   
}