<?php
class News
{
    public $newsId;
    public $title;
    public $image;
    public $url;
    public $type;


    public function __construct($newsId, $title, $image,$url,$type)
    {
        $this->newsId = $newsId;
        $this->title = $title;
        $this->url = $url;
        $this->image = $image;
        $this->type = $type;
       
    }
}
