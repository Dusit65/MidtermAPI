<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:DELETE"); //GET = check getAll , POST = insert , PUT = update , DELETE = delete
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php";

//create instant object
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//set value to Model variable
$trip->trip_id = $data->trip_id;


//call deleteTrip function
$result = $trip ->deleteTrip();

if ($result == true){
    //inset update delete complete
    echo json_encode(array("message" => "1"));
}else{
    //inset update delete fail  
    echo json_encode(array("message" => "0"));
}






