<?php
class User{
    private $conn;
    private $table_name = "users";
    public $id, $first_name, $last_name, $email, $mobile, $password, $role, $status;

    public function __construct($db)  {
        $this->conn=$db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, email, mobile, password, role, status) VALUES  
        (:first_name, :last_name, :email, :mobile, :password, :role, :status)";
        $stmt= $this->conn->prepare($query);

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":status", $this->status);
        
        if($stmt->execute()){
            return ["success" => true, "message" => "user registered successfully. pls verify your account."];
        }else{
            return ["success" => false, "message" => "user registration failed. pls try again"];

        }
    }
    public function emailExists(){
        $query = "SELECT id from " . $this->table_name . " WHERE email =:email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt ->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->rowCount()> 0;
    }

    public function login() {
        // Prepare the SQL query to select the user by email
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        // Bind the email parameter
        $stmt->bindParam(":email", $this->email);
        
        $stmt->execute();
        
        
        if ($stmt->rowCount() > 0) {
            // Fetch  user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
            if (password_verify($this->password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['role'] = $user['role'];
                
                return [
                    "success" => true,
                    "message" => "Login successful.",
                    "user" => $user 
                ];
            } else {
                // Password is incorrect
                return [
                    "success" => false,
                    "message" => "Invalid password."
                ];
            }
        } else {
            // No user found with that email
            return [
                "success" => false,
                "message" => "User  not found."
            ];
        }
    }
    
}
?>