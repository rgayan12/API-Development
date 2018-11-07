<?php
// required headers
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

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name))
 {
    $product->id = $data->id;
    $product->name = $data->name;
   
    if($product->Update()){
       
       http_response_code(200);
       
       echo json_encode(array("message" => "Product Updated"));
        
    }
     else {
        http_response_code(503);
        
        echo json_encode(array("Message" => "Unable to Update product"));
     }
     
 
 }

