<?php
class Database {

   private $host = "localhost";
   private $db_name = "api_db";
   private $dbuser = "root";
   private $dbpass = "root";
   public $conn;
   

    public function getConnection()
    {
      $this->conn = null;
      
      try{
        $this->conn = new PDO("mysql:host=" . $this->host .";dbname=" . $this->db_name, $this->dbuser, $this->dbpass);
        $this->conn->exec("set names utf8");
      }
      catch(PDOException $e){
        echo "Connection Error" . $e->getMessage();
      }
     return $this->conn; 
    }   
   
}  
   
   
   
     
   