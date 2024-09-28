<?php
//getAlltripByUserIdLocation
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");//GET = check get all, POST = insert , PUT = update , DELETE = delete
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php";

//create instant object
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//If else ตรวจสอบค่าว่างหรือไม่
If(!empty($data->min_cost) && !empty($data->max_cost)){
    $trip->user_id = $data->user_id;
    trip->location_name = $data->location_name;

    $result = $trip->getAlltripByUserIdLocation();

    if($result->rowCount() > 0){
        //มีข้อมูล
        $resultInfo = array();
        //Extract ข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
        while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($resultData);
            //สร้างตัวแปรอาร์เรย์เก็บข้อมูล
            $resultArray = array(
                "message" => "1",
                "user_id" => $user_id,
                "start_date" => $start_date,
                "end_date" => $end_date,
                "location_name" => $location_name,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "cost" => $cost
            );
            array_push($resultInfo, $resultArray);
        }
        echo json_encode($resultInfo, JSON_UNESCAPED_UNICODE);
    }else{
        //ไม่มีข้อมูล
        echo json_encode(array("message" => "0"));
    }
}else{
    //หากข้อมูลไม่ครบ
    echo json_encode(array("message" => "ข้อมูลไม่ครบ กรุณากรอกข้อมูลให้ครบ"));
}
?>