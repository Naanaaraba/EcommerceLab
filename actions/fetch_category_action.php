<?php
header('Content-Type: application/json');

$response = array();


require_once '../controllers/category_controller.php';
$all_categories = fetch_category_ctr();
  if(!empty($all_categories)){
    $response['status'] = 'success';
    $response['data'] = $all_categories;
  }else{
    $response['status'] = 'error';
    $response['data'] = [];
  }

  echo json_encode($response);
/*
function display_category_fxn(){
    $all_categories = fetch_category_ctr();
    foreach($all_categories as $category ){
        echo'<tr>
        <td>'.$category['cat_id'].'</td> 
        <td>'.$category['cat_name'].'</td>
        <td>
          <a href="category.php?delete=1" class="delete-link" onclick="return confirm("Delete this category?")">Delete</a>
        </td>
      </tr>';
    }
}*/