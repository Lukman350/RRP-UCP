<?php

// Database class
class Database {
  private $host = "13.251.156.119",
          $user = "root",
          $pass = "",
          $dbname = "relivedrp";

  public $db;

  public function __construct() {
    try {
      $this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";", $this->user, $this->pass);
    } catch (PDOException $th) {
      die($th->getMessage());
    }
  }

  public function getCURL($url) {
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch);
    curl_close($ch);      
    return json_decode($output, true);
  }

  public function fetchAccount($username) {
    $query = $this->db->prepare("SELECT * FROM `accounts` WHERE `Username` = '$username'");
    $user = [];
    $query->execute();
    if ($query->rowCount() > 0) {
      $user[] = $query->fetch(PDO::FETCH_ASSOC);
      return $user;
    }
  }

  public function fetchChar($id) {
    $query = $this->db->prepare("SELECT * FROM `characters` WHERE `ID` = '$id'");
    $query->execute();
    if ($query->rowCount() > 0) {
      while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
        return $user;
      }
    }
  }

  public function checkChar($char) {
    $query = $this->db->prepare("SELECT * FROM `characters` WHERE `Character` = '$char'");
    $query->execute();
    if ($query->rowCount() > 0) return true;
    else return false;
  }

  public function checkAccount($username) {
    $query = $this->db->prepare("SELECT * FROM accounts WHERE Username = '$username'");
    $query->execute();
    if ($query->rowCount() > 0) return true;
    else return false;
  }

  public function charGetCount($username) {
    $query = $this->db->prepare("SELECT * FROM `characters` WHERE `Username` = '$username'");
    $query->execute();
    return $query->rowCount();
  }

  public function checkEmail($email)
  {
    $query = $this->db->prepare("SELECT * FROM accounts WHERE Email = '$email'");
    $query->execute();
    if ($query->rowCount() > 0) return true;
    else return false;
  }

  public function getUserIP()
  {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
      $ip = $_SERVER['HTTP_CLIENT_IP'];  
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    } else {  
      $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
  }
}
