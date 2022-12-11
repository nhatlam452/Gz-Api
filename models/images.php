<?php
class Images
{   
    public $imageId;
    public $url;

    public function __construct($imageid, $url)
    {
        $this->imageid = $imageid;
        $this->url = $url;

    }

    /**
     * Get the value of imageid
     */
    public function getImageid()
    {
        return $this->imageid;
    }

    /**
     * Set the value of imageid
     */
    public function setImageid($imageid): self
    {
        $this->imageid = $imageid;

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }
}
