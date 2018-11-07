<?php
//Required Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../Config/database.php';
require_once '../Objects/product.php';


    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    
    //Get the Product ID directly
   $product->id = isset($_GET['id']) ? $_GET['id'] : die();
   
   $data = json_decode(file_get_contents("php://input"));
   
   $product->id = $data->id;
   
   if($product->Delete()) {
    
    http_response_code(200);
    
    echo json_encode(array("message" => "Product Deleted"));
    
    
   }
   else {
    
    http_response_code(503);
    
    echo json_encode(array("message" => "Unable to delete the product"));
    
   }
