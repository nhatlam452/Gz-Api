<?php
class DBConfig
{
    private $connect;
    public function getConnect()
    {
        try {
            $this->connect = new PDO("mysql:host=localhost:3306;dbname=musical", 'root', '');
            
            return $this->connect;
        } catch (Exception $ex) {
            echo "Cann't connect to database " . $ex->getMessage();
        }
    }
}
