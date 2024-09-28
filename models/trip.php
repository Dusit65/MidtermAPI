<?php

class Trip {
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $trip_id;
    public $user_id;
    public $start_date;
    public $end_date;
    public $location_name;
    public $latitude;
    public $longitude;
    public $cost;

    //ตัวแปรสารพัดประโยชน์
    public $message;
     //constructor
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }
    //----------------------------------------------------------
    //function การทำงานที่ล้อกับส่วนของ apis

    //function newTrip
    public function newTrip()
    {
    //ตัวแปรคำสั่งsql
    $strSQL = "INSERT INTO trip_tb 
    (user_id,start_date,end_date,location_name,latitude,longitude,cost) 
    VALUES
    (:user_id,:start_date,:end_date,:location_name,:latitude,:longitude,:cost)";
        
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->start_date = htmlspecialchars(strip_tags($this->start_date));
    $this->end_date = htmlspecialchars(strip_tags($this->end_date));
    $this->location_name = htmlspecialchars(strip_tags($this->location_name));
    $this->latitude = htmlspecialchars(strip_tags($this->latitude));
    $this->longitude = htmlspecialchars(strip_tags($this->longitude));
    $this->cost = htmlspecialchars(strip_tags($this->cost));
    
    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":start_date", $this->start_date);
    $stmt->bindParam(":end_date", $this->end_date);
    $stmt->bindParam(":location_name", $this->location_name);
    $stmt->bindParam(":latitude", $this->latitude);
    $stmt->bindParam(":longitude", $this->longitude);
    $stmt->bindParam(":cost", $this->cost);
    
    

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    }

    //getAlltripByUserId
    public function getAlltripByUserId()
    {
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id";
        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    // function getAlltripByUserIdDate 
    public function getAlltripByUserIdDate()
    {
        $strSQL = "SELECT * FROM trip_tb" . " WHERE user_id = :user_id AND start_date >= :start_date AND end_date <= :end_date";

        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));

        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->execute();
        return $stmt;
    }

    //function getAlltripByUserIdLocation 
    public function getAlltripByUserIdLocation()
    {
        $location = "%" . htmlspecialchars(strip_tags($this->location_name)) . "%";
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND location_name LIKE :location_name";

        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $this->location_name = htmlspecialchars(strip_tags($this->location_name));

        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":location_name", $location);
        $stmt->execute();
        return $stmt;
    }

    //function getAlltripByUserIdCost 
    public function getAlltripByUserIdCost()
    {
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND cost BETWEEN :min_cost AND max_cost";

        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $this->cost = htmlspecialchars(strip_tags($this->cost));

        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":min_cost", $this->min_cost);
        $stmt->bindParam(":max_cost", $this->max_cost);
        $stmt->execute();
        return $stmt;
    }

    //function updateCustAPI
public function updateTrip(){   
    
    $strSQL = "UPDATE trip_tb SET 
    user_id = :user_id, 
    start_date = :start_date, 
    end_date = :end_date,
    location_name = :location_name,
    latitude = :latitude,
    longitude = :longitude,
    cost = :cost
    WHERE trip_id = :trip_id;";
    
    //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
    
    $this->trip_id = intval(htmlspecialchars(strip_tags($this->trip_id)));
    $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
    $this->start_date = htmlspecialchars(strip_tags($this->start_date));
    $this->end_date = htmlspecialchars(strip_tags($this->end_date));
    $this->location_name = htmlspecialchars(strip_tags($this->location_name));
    $this->latitude = htmlspecialchars(strip_tags($this->latitude));
    $this->longitude = htmlspecialchars(strip_tags($this->longitude));
    $this->cost = htmlspecialchars(strip_tags($this->cost));

    //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters

    $stmt->bindParam(":trip_id", $this->trip_id);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":start_date", $this->start_date);
    $stmt->bindParam(":end_date", $this->end_date);
    $stmt->bindParam(":location_name", $this->location_name);
    $stmt->bindParam(":latitude", $this->latitude);
    $stmt->bindParam(":longitude", $this->longitude);
    $stmt->bindParam(":cost", $this->cost);

    //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}   

    //function delete diaryfood
    public function deleteTrip()
    {
        $strSQL = "DELETE FROM trip_tb WHERE trip_id = :trip_id";
        $this->trip_id = intval(htmlspecialchars(strip_tags($this->trip_id)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":trip_id", $this->trip_id);
        $stmt->execute();
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}