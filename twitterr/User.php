<?php
class User {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "connexion";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getUserName($user_id) {
        $sql = "SELECT * FROM user WHERE id='$user_id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
        } else {
            return "Error fetching user data.";
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}

$user = new User();
$username = $user->getUserName($user_id);
echo $username;
?>
