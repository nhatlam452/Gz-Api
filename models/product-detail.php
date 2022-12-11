<?php
class ProductDetail extends product
{
    public $productDetailId;
    public $top;
    public $back;
    public $neck;
    public $fingerBoard;
    public $bridge;
    public $origin;
    public $video;
    public $listImage;
    
    public function __construct($productDetailId, $top, $back, 
                                $neck,$fingerBoard,$bridge,$origin,$listImage,$video,$productName,
                                $description,$price,$discount)
    {   
        $this->productDetailId = $productDetailId;
        $this->top = $top;
        $this->back = $back;
        $this->neck = $neck;
        $this->fingerBoard = $fingerBoard;
        $this->bridge = $bridge;
        $this->origin = $origin;
        $this->video = $video;
        $this->listImage = $listImage;
        $this->productName = $productName;
        $this->description = $description;
        $this->price = $price;
        $this->discount = $discount;



    }

}
