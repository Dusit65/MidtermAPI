<?php

class User {
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $user_id;
    public $username;
    public $password;
    public $email;

    //ตัวแปรสารพัดประโยชน์
    public $message;
     //constructor
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }
    //----------------------------------------------------------
    //function การทำงานที่ล้อกับส่วนของ apis

    public function checkUserPassword(){
        $strSQL = "SELECT * FROM myprofile_tb WHERE username = :username AND password = :password";

    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->password = htmlspecialchars(strip_tags($this->password));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":password", $this->password);

    //สั่งsqlให้ทำงาน
    $stmt->execute();
    //ส่งค่าการทำงานกลับไปยังจุดเรียกใช้งานฟังก์ชั่น 
    return $stmt;
    }


    //function newUser
    public function newUser()
    {
    //ตัวแปรคำสั่งsql
    $strSQL = "INSERT INTO trip_tb
    (username,password,email) 
    VALUES
    (:username,:password,:email)";
        
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->email = htmlspecialchars(strip_tags($this->email));
    

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":email", $this->email);
    

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    }

}