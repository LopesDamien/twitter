<?php
require_once('connexion.php');

class Message {
  private $conn;
  private $user_id;
  private $receivedMessagesIds;

  public function __construct($conn, $user_id, &$receivedMessagesIds) {
    $this->conn = $conn;
    $this->user_id = $user_id;
    $this->receivedMessagesIds = &$receivedMessagesIds;
  }

  public function addMessage($inputText) {
    if (strlen($inputText) < 3) {
      return "Le texte doit contenir au moins 3 caractères.";
    }

    $texte = mysqli_real_escape_string($this->conn, $inputText);
    $dateHeure = date('Y-m-d H:i:s');
    $sql = "INSERT INTO messages (user_id, message, Date) VALUES ('$this->user_id', '$texte', '$dateHeure')";
    

    if (mysqli_query($this->conn, $sql)) {
      $idDuMessage = mysqli_insert_id($this->conn);
      $this->receivedMessagesIds[] = $idDuMessage;
      return "Le message a été enregistré avec succès.";
    } else {
      return "Erreur lors de l'insertion du message dans la base de données: " . mysqli_error($this->conn);
    }
  }
}

if (isset($_POST['etext'])) {
  $inputText = $_POST["etext"];

  $conn = mysqli_connect('localhost', 'root', '', 'connexion');
  if (!$conn) {
    die("La connexion a échoué: " . mysqli_connect_error());
  }

  $receivedMessagesIds = [];
  $message = "";

  $messageObj = new Message($conn, $user_id, $receivedMessagesIds);
  $result = $messageObj->addMessage($inputText);

  if ($result === "Le message a été enregistré avec succès.") {
    header('Location: page.php');
    exit;
  } else {
    $message = $result;
  }

  mysqli_close($conn);
}
