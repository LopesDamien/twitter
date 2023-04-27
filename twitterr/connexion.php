<?php

class Connexion
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM user WHERE logemail='$email' AND logpass='$password'";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION["userId"] = $row["id"];
            $_SESSION["logname"] = $row["logname"];
            header("Location: page.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    }

    public function register($name, $email, $password)
    {
        $sql = "INSERT INTO user (logname, logemail, logpass) VALUES ('$name', '$email', '$password')";
        if ($this->conn->query($sql) === TRUE) {
            header("Location: page.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

?>