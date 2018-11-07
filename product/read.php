<?php
// Required Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include database and object files
require_once '../Config/database.php';
require_once '../Objects/product.php';

//Instanciate database and product object
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

//Query Product
$stmt = $product->read();
$num = $stmt->rowCount();

if($num > 0) {
   
   $products_arr = array();
   $products_arr["records"] = array();
  
   //var_dump($products_arr);
  
   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
   extract($row);
        
    
    $product_item =array(
        "id" => $id,
        "name" => $name,
        "description" => html_entity_decode($description),
        "price" => $price,
        "category_id" => $category_id,
        "category_name" => $category_name
    );
    
    array_push($products_arr["records"], $product_item);
    
    }
    
    http_response_code(200);

      echo json_encode($products_arr);
  
    }
  
    else {
        http_response_code(404);
        
        echo json_decode(
            array("message" => "No products found.")
        );
    }

