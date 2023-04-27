<?php
class Database
{
    // Instance unique de la classe Database
    private static $instance = null;

    // Paramètres de connexion à la base de données
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "connexion";

    // Objet de connexion à la base de données
    private $conn;

    // Constructeur privé pour empêcher l'instanciation directe de la classe
    private function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connexion échouée : " . $this->conn->connect_error);
        }

        echo "Connexion réussie à la base de données.";
    }

    // Méthode pour récupérer l'instance unique de la classe Database
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    // Méthode pour exécuter une requête SQL
    public function query($sql)
    {
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Erreur de requête : " . $this->conn->error);
        }

        return $result;
    }

    // Destructeur pour fermer la connexion à la base de données
    public function __destruct()
    {
        $this->conn->close();
    }
}

// Utilisation de la classe Database pour exécuter la requête SQL
$db = Database::getInstance();

$sql = "SELECT messages.*, user.logname FROM messages 
        LEFT JOIN user ON messages.user_id = user.id ORDER BY messages.id DESC";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Traiter les résultats
    while ($row = $result->fetch_assoc()) {
        echo "Auteur : " . $row["logname"] . "<br>";
        echo "Message : " . $row["message"] . "<br><br>";
    }
} else {
    echo "Aucun résultat trouvé.";
}
?>
