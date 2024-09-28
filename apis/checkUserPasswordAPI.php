<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET"); //GET = check getAll , POST = insert , PUT = update , DELETE = delete
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/user.php";

//create instant object
$connDB = new ConnectDB();
$user = new User($connDB->getConnectionDB());

//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//set value to Model variable
$user->username = $data->username;
$user->password = $data->password;

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $user->checkUserPassword();

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
if ($result->rowCount() > 0) {
    //Extract ข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);
    //สร้างตัวแปรอาร์เรย์เก็บข้อมูล
    $resultArray = array(
        "message" => "1",
        "user_id" => $user_id,
        "username" => $username,
        "email" => $email
        
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    //echo json_encode(array("message" => "เข้าสู่ระบบ!!"));
} else {
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode(array("message" => "ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง"));
}
