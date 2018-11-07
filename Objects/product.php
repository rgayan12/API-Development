<?php
class Product {
  private $conn;
  private $table_name = "products";
  
  public $id;
  public $name;
  public $description;
  public $price;
  public $category_id;
  public $category_name;
  public $created;
  public $errormsg;
  
 public function __construct($db) {
     $this->conn = $db;
    }
    
   public function read(){
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";
    
    $stmt = $this->conn->prepare($query);
    
    $stmt->execute();
    
    return $stmt;
    }
    
    public function create(){
      
      $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
    
    }

    public function readOne() {
     
     $query = "SELECT c.name as category_name, h.id, h.name, h.description, h.price, h.category_id, h.created
             FROM
                " .$this->table_name." h
                Left JOIN
                   categories c
                    ON h.category_id = c.id
                    WHERE
                    h.id = :id
                    LIMIT
                    0,1";
                    
      $stmt = $this->conn->prepare($query);
      
      $stmt->bindParam(":id", $this->id);
      
      $stmt->execute();
      
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
      extract($row);
      
      $this->name = $name;
      $this->description = html_entity_decode($description);
      $this->price = $price;
      $this->category_id = $category_id;
      $this->category_name = $category_name;
      
    }
    
   public function Update() {
    
    $sqlquery = "UPDATE " .$this->table_name. "
                 SET
                   name = :name
                 WHERE
                   id = :id";
                 
    $stmt = $this->conn->prepare($sqlquery);
    
    $this->name = htmlspecialchars(strip_tags($this->name));
    
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":name", $this->name);
                 
    if($stmt->execute()) {
      return true;
     } 
    else {
     return false;
    }
    
    
    }
    
    public function Delete(){
     
     $query = "DELETE FROM " . $this->table_name. " WHERE id = :id";
     
     $stmt = $this->conn->prepare($query);
     $this->id = htmlspecialchars(strip_tags($this->id));
     $stmt->bindParam(":id", $this->id);
     
     if($stmt->execute()) {
      return true;
     }
     else{
      return false;
     }
     
    }
   
    




}