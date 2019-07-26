<?php 
  class DBOperations{
    private $con;
    function __construct(){
        require_once dirname(__FILE__).'/DBConnect.php';
        $db = new DBConnect();
        $this-> con = $db->connect();
    } 
    //CRUD -> C -> create 
    public function createUser($username,$email,$pass){
      if($this->isUserExist($username,$email)){
        return 0;

      }else{
       $password = md5($pass);
       $stmt = $this->con->prepare("INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES (NULL, ?, ?, ?);");
       $stmt->bind_param("sss",$username,$email,$password);
       if($stmt->execute()){
           return 1;
       }else{
           return 2;
       }

      }
       
    }

    public function userLogin($username,$pass){
      $password = md5($pass);
      $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
      $stmt ->bind_param("ss",$username,$password);
      $stmt ->execute();
      $stmt ->store_result();
      return $stmt ->num_rows > 0;

    }

    public function getUserByUsername($username){
      $stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
      $stmt ->bind_param("s",$username);
      $stmt ->execute();
      return $stmt ->get_result()->fetch_assoc();
    }

    private function isUserExist($username, $email){
      $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
      $stmt->bind_param("ss",$username,$email);
      $stmt->execute();
      $stmt->store_result();
      return $stmt->num_rows > 0;

    }
  }
?>