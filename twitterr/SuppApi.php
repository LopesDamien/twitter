<?php

// Connexion à la base de données
class Database {
    private $host = "localhost";
    private $db_name = "connexion";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Classe pour les messages
class Message {
    // Propriétés
    public $id;
    public $user_id;
    public $avatar;
    public $message;
    public $Date;

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Méthode pour supprimer un message en fonction de l'utilisateur connecté
    public function deleteMessage($user_id, $id){
        $query = "DELETE FROM messages WHERE user_id = :user_id AND id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}

// Vérification si l'utilisateur est connecté

if(!isset($_SESSION['user_id'])){
    header('Location: page.php');
    exit();
}

// Suppression du message
if(isset($_POST["delete"])){
    $database = new Database();
    $db = $database->getConnection();
    $message = new Message($db);

    $user_id = $_SESSION['user_id'];
    $id = $_POST["delete"];

    if($message->deleteMessage($user_id, $id)){
        echo "Message supprimé.";
    } else {
        echo "Erreur lors de la suppression du message.";
    }
}

?>
