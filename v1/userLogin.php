<?php 

require_once ('../include/DBOperations.php');

$response = array();

  if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['username']) and isset($_POST['password'])){

        $db = new DBOperations();

        if($db->userLogin($_POST['username'],$_POST['password'])){
            $user = $db->getUserByUsername($_POST['username']);
            $response['error'] = false;
            $response['id'] = $user['id'];
            $response['email'] = $user['email'];
            $response['username'] = $user['username'];
            
        }else{
            $response['error'] = true;
            $response['message'] = "Invalid Username or Password, Please try again!";
        }



      }else{
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
      }
  }else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
  }  

  echo json_encode($response);

?>