<?php
class Respone
{
    public $respone_code;
    public $error;
    public $message;
    public $data;

    public function __construct($respone_code, $error, $message, $data)
    {
        $this->respone_code = $respone_code;
        $this->error = $error;
        $this->message = $message;
        $this->data = $data;
    }
    public static function getDefaultInstance()
    {
        return new self(null, false, null, null);
    }

    /**
     * Get the value of respone_code
     */
    public function getResponeCode()
    {
        return $this->respone_code;
    }

    /**
     * Set the value of respone_code
     */
    public function setResponeCode($respone_code): self
    {
        $this->respone_code = $respone_code;

        return $this;
    }

    /**
     * Get the value of error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the value of error
     */
    public function setError($error): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     */
    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }
}
