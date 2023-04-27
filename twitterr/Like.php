<?php

class Like {
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function toggleLike($message_id, $user_id) {
    $query = "SELECT * FROM likes WHERE message_id = :message_id AND user_id = :user_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":message_id", $message_id, PDO::PARAM_INT);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      // Si l'utilisateur a déjà liké le message, on supprime le like
      $query = "DELETE FROM likes WHERE message_id = :message_id AND user_id = :user_id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":message_id", $message_id, PDO::PARAM_INT);
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
    } else {
      // Sinon, on ajoute un like
      $query = "INSERT INTO likes (user_id, message_id, countLikes) VALUES (:user_id, :message_id, 1) ON DUPLICATE KEY UPDATE countLikes = countLikes + 1";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":message_id", $message_id, PDO::PARAM_INT);
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  public function getLikesCount($message_id) {
    $query = "SELECT SUM(countLikes) as likesCount FROM likes WHERE message_id = :message_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":message_id", $message_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['likesCount'] > 0) {
      return $result['likesCount'];
    } else {
      return 0;
    }
  }
}

?>
