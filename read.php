<?php 
header("Content-Type: apllication/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'product.php';

$database = new Database();
$db = $database->getConnection();

$product = new product($db);

$stmt = $product->read();
$num = $stmt->rowCount();

if($num>0){
    $products_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $product_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
        array_push($products_arr, $product_item);
    }
    http_response_code(200);
    echo json_encode($products_arr);
}else{
    http_response_code(404);

    echo json_encode(
        array("message" => "No product found.")
    );  
}
?>