<?php 
    
    require_once ('../include/DBOperations.php');

    $response = array();

    if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['username']) and 
              isset($_POST['email']) and
               isset($_POST['password'])){
                   //operate the data further

             $db = new DBOperations(); 

             $result = $db->createUser( $_POST['username'],
                                         $_POST['email'],
                                         $_POST['password']); 
             if($result == 1){
                 $response['error'] = false;
                 $response['message'] = "User registered successfully";
             }else if($result == 2){
                $response['error'] = true;
                $response['message'] = "Some error occurred please try again";
             }else if($result == 0){
                $response['error'] = true;
                $response['message'] = "It seems you are already registred, Please you different User name and email!";

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