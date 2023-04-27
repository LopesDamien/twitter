<?php
// Connexion à la base de données
class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        // Connexion à la base de données
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

        // Vérification de la connexion
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
    }

    public function __destruct() {
        // Fermeture de la connexion à la base de données
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }

    public function getMessages() {
        $messages = array();

        // Récupération de tous les messages avec la date d'envoi
        $sql = "SELECT messages.id, REPLACE(REPLACE(messages.message, '<', '*'), '>', '*') AS message, messages.Date, user.logname FROM messages INNER JOIN user ON messages.user_id = user.id";
        $result = mysqli_query($this->conn, $sql);

        // Stockage des messages dans un tableau
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $messages[] = array(
                    'id' => $row['id'],
                    'message' => $row['message'],
                    'date' => $row['Date'],
                    'logname' => $row['logname']
                );
            }
        }

        return $messages;
    }
}

// Fonction pour formater la date dans le format que vous souhaitez
function formatDate($date) {
    return date("d/m/Y H:i:s", strtotime($date));
}

// Utilisation de la classe Database pour récupérer les messages
$database = new Database("localhost", "root", "", "connexion");


// Stockage des messages dans un tableau
$allMessages = array();


// Affichage des messages et de la date d'envoi pour chaque message
foreach ($allMessages as $message) {
    echo "(Message ID: " . $message['id'] . ")<p>";
    echo  formatDate($message['date']) . "</span><br>";
}

?>