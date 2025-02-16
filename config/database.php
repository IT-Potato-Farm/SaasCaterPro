<?php  

class Database{
    private $host = "localhost";
    private $db_name = "saascaterpro";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection(){
        $this->conn =null; //pag de makuha connection
        try {
            $this-> conn = new PDO("mysql:host=" .$this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            http_response_code(500);
            echo json_encode(["message" => "Database connection error.", "error" => $exception->getMessage()]);
            exit();
        }
        return $this->conn;
    }
}

?>