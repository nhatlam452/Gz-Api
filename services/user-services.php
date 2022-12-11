<?php

include_once '../configs/db-config.php';
include_once '../models/respone.php';
include_once '../models/user.php';
include_once '../models/cart.php';
include_once '../models/address.php';
include_once '../models/wish.php';
include_once '../models/comment.php';
include_once '../models/store.php';

include_once '../models/order.php';
include_once '../models/news.php';
include_once '../models/order-detail.php';

class UserServices
{
    public $connect;
    public function __construct()
    {
        $this->connect = (new DBConfig())->getConnect();
    }
    public function getAllStore()
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT STOREID,STORENAME,LATITUDE,LONGITUDE,STOREADDRESS FROM tblstore ";

            $stmt = $this->connect->prepare($query);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listStore = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $store = new Store(
                    $STOREID,
                    $STORENAME,
                    $LATITUDE,
                    $LONGITUDE,
                    $STOREADDRESS

                );
                array_push($listStore, $store);
            }

            $response->setMessage("get all store success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listStore);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function checkUserExits($phoneNumber)
    {
        $respone =  Respone::getDefaultInstance();
        try {
            $query = "SELECT PHONENUMBER FROM tbluser WHERE PHONENUMBER = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $phoneNumber);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $respone->setResponeCode(1);
                $respone->setMessage("User is exits");
            } else {
                $respone->setResponeCode(2);
                $respone->setMessage("Your Phone number is not exits");
            }
        } catch (Exception $ex) {
            $respone->setError(true);
            $respone->setMessage("Cann't read query" . $ex->getMessage());
        }
        return $respone;
    }
    public function getPasswordByPhoneNumber($phoneNumber)
    {
        $respone =  Respone::getDefaultInstance();
        try {
            $query = "SELECT USERID,PASSWORD FROM tbluser WHERE PHONENUMBER = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $phoneNumber);
            $stmt->execute();
            $lstUser = [];
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $user = new User(
                    $USERID,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    $PASSWORD,
                    null,
                    null,
                    null,
                    null

                );
                array_push($lstUser, $user);
                $respone->setData($lstUser);
                $respone->setResponeCode(1);
            }
        } catch (Exception $ex) {
            $respone->setError(true);
            $respone->setMessage("Cann't read query" . $ex->getMessage());
        }
        return $respone;
    }
    public function getUserByFBID($fbId)
    {
        $respone =  Respone::getDefaultInstance();
        try {
            $query = "SELECT USERID,PHONENUMBER,FBID,EMAIL,AVATAR,PASSWORD,FIRSTNAME,LASTNAME,DOB,SALUTATION,NOTIFICATION,ROLE FROM tbluser WHERE FBID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $fbId);
            $stmt->execute();
            $lstUser = [];
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $user = new User(
                    $USERID,
                    $PHONENUMBER,
                    $FBID,
                    $EMAIL,
                    $AVATAR,
                    $FIRSTNAME,
                    $LASTNAME,
                    $PASSWORD,
                    $DOB,
                    $SALUTATION,
                    $NOTIFICATION,
                    $ROLE
                );
                array_push($lstUser, $user);
                $respone->setData($lstUser);
                $respone->setMessage(" get fb user Info");
                $respone->setResponeCode(1);
                $respone->setError(false);
            }
        } catch (Exception $ex) {
            $respone->setError(true);
            $respone->setMessage("Cann't read query" . $ex->getMessage());
        }
        return $respone;
    }
    public function getUserByUsername($userId)
    {
        $respone =  Respone::getDefaultInstance();
        try {
            $query = "SELECT USERID,PHONENUMBER,FBID,EMAIL,AVATAR,PASSWORD,FIRSTNAME,LASTNAME,DOB,SALUTATION,NOTIFICATION,ROLE FROM tbluser WHERE USERID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            $lstUser = [];
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $user = new User(
                    $USERID,
                    $PHONENUMBER,
                    $FBID,
                    $EMAIL,
                    $AVATAR,
                    $FIRSTNAME,
                    $LASTNAME,
                    $PASSWORD,
                    $DOB,
                    $SALUTATION,
                    $NOTIFICATION,
                    $ROLE
                );
                array_push($lstUser, $user);
                $respone->setData($lstUser);
                $respone->setResponeCode(1);
                $respone->setMessage("get User Success");
                $respone->getData()[0]->setPassword(null);
                $respone->setError(false);
            } else {
                $respone->setMessage("Cann't get fb user Info");
                $respone->setResponeCode(2);
                $respone->setError(true);
            }
        } catch (Exception $ex) {
            $respone->setError(true);
            $respone->setMessage("Cann't read query" . $ex->getMessage());
        }
        return $respone;
    }
    public function insertUser($data)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "INSERT INTO tbluser SET USERID = NULL, PHONENUMBER = ?, 
            FBID = NULL,EMAIL =NULL, FIRSTNAME = ?,LASTNAME =?, PASSWORD = ?,
            DOB=?,SALUTATION=?,NOTIFICATION=?,ROLE=?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->phoneNumber);
            $stmt->bindParam(2, $data->firstName);
            $stmt->bindParam(3, $data->lastName);
            $stmt->bindParam(4, $data->password);
            $stmt->bindParam(5, $data->dob);
            $stmt->bindParam(6, $data->salutation);
            $stmt->bindParam(7, $data->notification);
            $stmt->bindParam(8, $data->role);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $query = "SELECT USERID FROM TBLUSER WHERE PHONENUMBER = ? ";
                $stmt = $this->connect->prepare($query);
                $stmt->bindParam(1, $data->phoneNumber);
                $stmt->execute();
                $this->connect->commit();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    $data->uId = $USERID;
                    $respone = $this->insertAddress($data);
                } else {
                    $this->connect->rollBack();
                    $respone->setError(true);
                    $respone->setResponeCode(2);
                    $respone->setMessage("Insert address failed");
                }
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Insert user failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(7);
        }
        return $respone;
    }


    public function updateUserPassword($phoneNumber, $newPassword)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "UPDATE tbluser SET PASSWORD = ?
            WHERE PHONENUMBER = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $newPassword);
            $stmt->bindParam(2, $phoneNumber);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Update Password sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Update password failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function getCartByPhonenumber($userId)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT CARTID, DISCOUNT,USERID, TBLCART.PRODUCTID AS PRODUCTID,PRODUCTNAME, URL,PRICE, TBLCART.QUANTITY, TBLIMAGES.IDEFAULT FROM TBLCART 
            INNER JOIN tblproduct ON tblproduct.PRODUCTID = TBLCART.PRODUCTID
            INNER JOIN tblimages ON tblproduct.PRODUCTID = tblimages.PRODUCTID
            INNER JOIN tblpromotion ON tblproduct.PROMOTIONID = tblpromotion.PROMOTIONID
            GROUP BY tblcart.PRODUCTID
            HAVING tblimages.IDEFAULT = 1 AND USERID= ?
            order by CARTID asc
            ";

            $stmt = $this->connect->prepare($query);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            $listCart = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $cart = new Cart($CARTID, $USERID, $PRODUCTID, $PRODUCTNAME, $QUANTITY, $URL, $PRICE, $DISCOUNT);
                array_push($listCart, $cart);
            }
            $response->setMessage("get Cart success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listCart);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function insertAddress($data)
    {

        $respone = Respone::getDefaultInstance();
        try {
            $query = "INSERT INTO tbluseraddress SET 
            ADDRESSID = NULL , LOCATION = ?,WARD = ? , DISTRICT = ? 
            , CITY = ? , USERID = ?, ADDRESSNAME = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->address);
            $stmt->bindParam(2, $data->ward);
            $stmt->bindParam(3, $data->district);
            $stmt->bindParam(4, $data->city);
            $stmt->bindParam(5, $data->uId);
            $stmt->bindParam(6, $data->addressName);

            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Insert sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Insert address failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function insertComment($data)
    {

        $respone = Respone::getDefaultInstance();
        try {
            $query = "INSERT INTO tblcomments SET COMMENTID = NULL , USERID = ?,PRODUCTID = ? , CONTENT = ? , IMAGE = ?,DATE = ?,STATUS = 1";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->userId);
            $stmt->bindParam(2, $data->productId);
            $stmt->bindParam(3, $data->content);
            $stmt->bindParam(4, $data->img);
            $stmt->bindParam(5, $data->date);


            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Insert comment sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Insert comment failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function addToCart($userId, $productId, $quantity)
    {
        $respone = Respone::getDefaultInstance();
        try {

            $query = "select cartid from tblcart where userid = ? and productid = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $productId);
            $this->connect->beginTransaction();
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $query = "update tblcart set quantity =  ? where userid = ? and productid = ?";
                $stmt = $this->connect->prepare($query);
                $stmt->bindParam(1, $quantity);
                $stmt->bindParam(2, $userId);
                $stmt->bindParam(3, $productId);
                if ($stmt->execute()) {
                    $this->connect->commit();
                    $respone->setMessage("update cart sucess");
                    $respone->setError(false);
                    $respone->setResponeCode(1);
                } else {
                    $this->connect->rollBack();
                    $respone->setError(true);
                    $respone->setResponeCode(2);
                    $respone->setMessage("update cart failed");
                }
            } else {
                $query = "insert into tblcart set cartid = null ,quantity = ? ,userid = ?,productid = ?";
                $stmt = $this->connect->prepare($query);
                $stmt->bindParam(1, $quantity);
                $stmt->bindParam(2, $userId);
                $stmt->bindParam(3, $productId);
                if ($stmt->execute()) {
                    $this->connect->commit();
                    $respone->setMessage("insert cart sucess");
                    $respone->setError(false);
                    $respone->setResponeCode(1);
                } else {
                    $this->connect->rollBack();
                    $respone->setError(true);
                    $respone->setResponeCode(2);
                    $respone->setMessage("insert cart failed");
                }
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function updateUser($param, $value, $userId)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "UPDATE tbluser SET  $param = ? WHERE USERID=?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $value);
            $stmt->bindParam(2, $userId);

            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone = $this->getUserByUsername($userId);
                $respone->setMessage("Update Suucess");
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Update failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function removeCart($cartid)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "DELETE FROM tblcart WHERE CARTID=?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $cartid);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Remove cart sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Remove cart failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function getAllAddress($userId)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT ADDRESSID, LOCATION,WARD,DISTRICT,CITY,
             USERID, ADDRESSNAME FROM tbluseraddress WHERE USERID=?";

            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listAdress = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $address = new Address($ADDRESSID, $LOCATION, $WARD, $DISTRICT, $CITY, $USERID, $ADDRESSNAME);
                array_push($listAdress, $address);
            }
            $response->setMessage("get Address success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listAdress);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }

    public function getAllComment($productId)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT COMMENTID,TBLCMT.USERID,concat(FIRSTNAME,' ',LASTNAME) AS NAME,PRODUCTID,CONTENT,DATE,IMAGE,STATUS 
                    ,AVATAR 
            FROM tblcomments TBLCMT INNER JOIN tbluser TBLU
            WHERE TBLCMT.USERID = TBLU.USERID
            HAVING PRODUCTID=? and status =1";

            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $productId);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listAdress = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $address = new Comment($COMMENTID, $USERID, $PRODUCTID, $CONTENT, $DATE, $IMAGE, $STATUS, $AVATAR, $NAME);
                array_push($listAdress, $address);
            }
            $response->setMessage("get Address success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listAdress);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function updateAddress($data)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "UPDATE tbladdress SET LOCATION = ? WHERE PHONENUMBER = ? AND ADDRESSID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->location);
            $stmt->bindParam(2, $data->phonenumber);
            $stmt->bindParam(3, $data->addressid);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("update address sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("update address failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function setDefaultAddress($data)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "UPDATE tbladdress SET DEFAULTADDRESS = 1 WHERE PHONENUMBER=? AND ADDRESSID =?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->phonenumber);
            $stmt->bindParam(2, $data->addressid);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("update default address sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("update default address failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function setUnDefaultAddress($data)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "UPDATE tbladdress SET DEFAULTADDRESS = 0 WHERE PHONENUMBER=? AND ADDRESSID =?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->phonenumber);
            $stmt->bindParam(2, $data->addressid);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Remove default address sucess");
                $respone->setError(false);
                $respone->setData($listCart);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Remove default address failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function inserOrder($data)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "INSERT INTO tblorder SET  USERID = ?, STATUS = '1', CREATEDATE=?, 
            TOTAL=?,NOTE=?,ORDERMETHOD = ?,DFROM=?,DTO=?,PAYMENTMETHOD=?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->userId);
            $stmt->bindParam(2, $data->createDate);
            $stmt->bindParam(3, $data->total);
            $stmt->bindParam(4, $data->note);
            $stmt->bindParam(5, $data->orderMethod);
            $stmt->bindParam(6, $data->dFrom);
            $stmt->bindParam(7, $data->dTo);
            $stmt->bindParam(8, $data->paymentMethod);
            $this->connect->beginTransaction();
            $length = count($data->listCart,1);
            if ($stmt->execute()) {
           
                $lastId = $this->connect->lastInsertId();
                $this->connect->commit();
                for ($i = 0; $i <$length; $i++) {
                    $query = "INSERT INTO tblorderdetail SET 
                    ORDERID=$lastId, 
                    PRODUCTID = ?, 
                    QUANTITY = ? ";
                    $stmt = $this->connect->prepare($query);
                    $stmt->bindParam(1, $data->listCart[$i]->productId);
                    $stmt->bindParam(2, $data->listCart[$i]->quantity);
                    $this->connect->beginTransaction();
                    if ($stmt->execute()) {
                        $this->connect->commit();
                        $respone->setError(false);
                        $respone->setResponeCode(1);
                        $respone->setMessage("SUCCESS");
                    } else {
                        $this->connect->rollBack();
                        $respone->setError(true);
                        $respone->setResponeCode(2);
                        break;
                        return;
                    }
                }
                $query = "DELETE FROM tblcart WHERE USERID = ?";
                $stmt = $this->connect->prepare($query);
                $stmt->bindParam(1, $data->userId);
                $this->connect->beginTransaction();
                if ($stmt->execute()) {
                    $this->connect->commit();
                    $respone->setError(false);
                    $respone->setResponeCode(1);
                    $respone->setMessage("Length:".$length);
                } else {
                    $this->connect->rollBack();
                    $respone->setError(true);
                    $respone->setResponeCode(2);
                    $respone->setMessage("SUCCESSS");
                }
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Insert order failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function getOrderByPhoneNumber($userId)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT ORDERID, USERID, TOTAL,STATUS, NOTE,CREATEDATE,
            ORDERMETHOD,DFROM,DTO,PAYMENTMETHOD FROM tblorder 
            WHERE USERID = ?";

            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listOrder = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $order = new Order($ORDERID, $USERID,$STATUS, $TOTAL, $NOTE, $CREATEDATE, $ORDERMETHOD, $DFROM, $DTO,$PAYMENTMETHOD);
                array_push($listOrder, $order);
            }
            $response->setMessage("get all order success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listOrder);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function insertOrderDetail($data)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "INSERT INTO tblorderdetail SET ORDERDETAILID = NULL,
             PRODUCTID = ?, QUANTITY=?, ORDERID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->productid);
            $stmt->bindParam(2, $data->quantity);
            $stmt->bindParam(3, $data->orderid);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $this->connect->commit();
                $respone->setMessage("Insert order sucess");
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Insert order failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(5);
        }
        return $respone;
    }
    public function getOrderDetail($orderid)
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT PRODUCTNAME, QUANTITY, PRICE, (QUANTITY * PRICE) AS TOTAL 
            FROM tblorderdetail TBLODT
                INNER JOIN tblproduct TBLP ON TBLODT.PRODUCTID = TBLP.PRODUCTID WHERE ORDERID = ?";

            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $orderid);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $lstOrderDetail = [];
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch();
                extract($row);
                $orderDetail = new OrderDetail($PRODUCTNAME, $QUANTITY, $PRICE, $TOTAL);
                array_push($lstOrderDetail, $orderDetail);
            }

            $response->setMessage("get order detail success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($lstOrderDetail);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(false);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function getAllNews()
    {
        $response = Respone::getDefaultInstance();
        try {
            $query = "SELECT NEWSID,TITLE,IMAGE,URL,TYPE FROM tblnews";

            $stmt = $this->connect->prepare($query);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $listNews = [];
            while ($row = $stmt->fetch()) {
                extract($row);
                $news = new News($NEWSID, $TITLE, $IMAGE, $URL, $TYPE);
                array_push($listNews, $news);
            }

            $response->setMessage("get all news success");
            $response->setError(false);
            $response->setResponeCode(1);
            $response->setData($listNews);
        } catch (Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->setError(true);
            $response->setResponeCode(0);
        }
        return $response;
    }
    public function registerByFb($data)
    {
        $respone =  Respone::getDefaultInstance();
        try {
            $query = "INSERT INTO tbluser SET USERID = NULL, PHONENUMBER = NULL, FBID = ?,EMAIL =?,
            AVATAR=?, FIRSTNAME = ?,LASTNAME =?, PASSWORD = NULL,DOB=?,
            SALUTATION=NULL,NOTIFICATION=1,ROLE=1";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->fbId);
            $stmt->bindParam(2, $data->email);
            $stmt->bindParam(3, $data->avatar);
            $stmt->bindParam(4, $data->firstName);
            $stmt->bindParam(5, $data->lastName);
            $stmt->bindParam(6, $data->dob);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $query = "SELECT USERID FROM tbluser WHERE FBID = ? ";
                $stmt = $this->connect->prepare($query);
                $stmt->bindParam(1, $data->fbId);
                $stmt->execute();
                $this->connect->commit();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    $data->userId = $USERID;
                    $respone = $this->getUserByUsername($data->userId);
                    $respone->setMessage("Register Success");
                } else {
                    $this->connect->rollBack();
                    $respone->setError(true);
                    $respone->setResponeCode(2);
                    $respone->setMessage("Login failed. Please try again");
                }
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Can't get your info. Please try again");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(7);
        }
        return $respone;
    }
    public function checkFbIdExits($fbId)
    {
        $respone =  Respone::getDefaultInstance();
        try {
            $query = "SELECT FBID FROM tbluser WHERE FBID = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $fbId);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $respone->setError(false);
                $respone->setResponeCode(1);
            } else {
                $respone->setError(false);
                $respone->setResponeCode(2);
            }
        } catch (Exception $ex) {
            $respone->setError(true);
            $respone->setMessage("Cann't read query" . $ex->getMessage());
        }
        return $respone;
    }
    public function insertChat($data)
    {
        $respone = Respone::getDefaultInstance();
        try {
            $query = "INSERT INTO tblchat SET 
            CHATID = NULL, USERID = ?, MSG = ?,STATE =?, DATE = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(1, $data->phoneNumber);
            $stmt->bindParam(2, $data->firstName);
            $stmt->bindParam(3, $data->lastName);
            $stmt->bindParam(4, $data->password);
            $stmt->bindParam(5, $data->dob);
            $stmt->bindParam(6, $data->salutation);
            $stmt->bindParam(7, $data->notification);
            $stmt->bindParam(8, $data->role);
            $this->connect->beginTransaction();
            if ($stmt->execute()) {
                $query = "SELECT USERID FROM tbluser WHERE PHONENUMBER = ? ";
                $stmt = $this->connect->prepare($query);
                $stmt->bindParam(1, $data->phoneNumber);
                $stmt->execute();
                $this->connect->commit();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    $data->uId = $USERID;
                    $respone = $this->insertAddress($data);
                } else {
                    $this->connect->rollBack();
                    $respone->setError(true);
                    $respone->setResponeCode(2);
                    $respone->setMessage("Insert address failed");
                }
            } else {
                $this->connect->rollBack();
                $respone->setError(true);
                $respone->setResponeCode(2);
                $respone->setMessage("Insert user failed");
            }
        } catch (Exception $ex) {
            $respone->setMessage("Cann't read query" . $ex->getMessage());
            $respone->setError(true);
            $respone->setResponeCode(7);
        }
        return $respone;
    }
}
