<?php
session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="pagetweeter.css">
  <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/codemirror/5.22.0/codemirror.css'>
  <link rel='stylesheet' href='https://codepen.io/a-mt/pen/VdoWRK.css'>
  <link rel="stylesheet" href="pagetweet.css">
  <link rel="stylesheet" href="tweet.css">
  <link rel="stylesheet" href="style.css">


</head>

<body>
  <?php
  require_once("connexion.php");


  $ipserver = "localhost.";
  $nomBase = "connexion";
  $loginPrivilege = "root";
  $passPrivilege = "";

  try {
    $GLOBALS["pdo"] = new PDO('mysql:host=' . $ipserver . ';dbname=' . $nomBase . '', $loginPrivilege, $passPrivilege);
  } catch (Exception $e) {
    echo $e->getMessage();
  }


  if (isset($_POST["delete"])) {
    $delete = "DELETE FROM `messages` ";
    $result5 = $GLOBALS["pdo"]->query($delete);
  }
  ?>

  <!-- partial:index.partial.html -->
  <div class="page">
    <aside class="colonne-de-gauche">
      <div class="lignegauche">
        <a href="https://twitter.com"><img src="logosite.png" width="50"></a>

        <div class="textgauche">
          <?php

          if (!isset($_SESSION["userId"])) {
            header("Location: index.php");
            exit();
          }

          $user_id = $_SESSION["userId"];

          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "connexion";

          $conn = new mysqli($servername, $username, $password, $dbname);

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }


          $conn->close();
          ?>
          <nav>
            <nav>
              <ul>
                <li>
                  <a href="">Accueil</a>
                </li>
                <li>
                  <a href=""><b>Explorer</b></a>
                </li>
                <li>
                  <a href="">Messages</a>
                </li>
                <li>
                  <a href="">Signets</a>
                </li>
                <li>
                  <a href="">Listes</a>
                </li>
                <li>
                  <a href="">Profil</a>
                </li>
                <li>
                  <a href="">Plus</a>
                </li>
              </ul>
            </nav>
        </div>
      </div>
      <button class="btn odal-btn modal-trigger">Tweeter</button>

      <form action="" method="post">
        <input type="submit" class="deconnexiontwitter" name="deconnexion" value="Se déconnecter"></input>
      </form>
      <div class=bloctweet>
        <div class="modal-container">

          <div class="modal" role="dialog" aria-labelledby="modalTitle" aria-describedby="dialogDesc">

            <!-- partial:index.partial.html -->
            <div class="modal">

              <div class="modal-content" role="document">
                <div class="modal-header">

                  <button aria-label="close modal" class="btn close-modal modal-trigger">X</button>
                  <h3 class="modal-title">Écrire un nouveau Tweet</h3>
                </div>
                <div class="modal-body">
                  <div class="tweet-box-avatar">

                    <div class="avatar">
                      <?php

                      ?>
                    </div>
                  </div>
                  <div class="tweet-box-content">

                    <!-- CONTENTEDITABLE -->
                    <div class="tweet-content">
                      <div class="tweet-box">
                        <div class="tweet-toolbar">
                          <div class="tweet-box-extras"></div>
                          <div class="tweet-toolbar-button">
                            <form method="POST">
                            </form>
                          </div>
                        </div>

                        <?php
                        if (isset($_POST['deconnexion'])) {
                          session_unset();
                          session_destroy();
                          header("Location: index.php");
                        }


                        $conn = mysqli_connect("localhost", "root", "", "connexion");

                        if (!$conn) {
                          die("La connexion à la base de données a échoué: " . mysqli_connect_error());
                        }

                        require_once("Message.php");

                        ?>


                        <!-- Afficher le formulaire et le message -->
                        <form method="POST">
                          <input type="text" name="etext" class="rich-editor" spellcheck="true" placeholder="Quoi de neuf ?" minlength="3" maxlength="300" autocomplete="off" onkeypress="return (event.charCode != 60 && event.charCode != 62)">
                      </div>
                      <button type="submit" class="btn" id="preview ">Publier</button>

                      </form>
                      <div>

                      </div>
                    </div>


                    <!-- REMAINING CHARACTERS -->
                    <div class="character-counter js-character-counter"></div>

                    <!-- EMOJI PICKER -->
                    <div class="emojipicker-btn EmojiPicker-trigger">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                        <path d="M15 0C6.729 0 0 6.729 0 15s6.729 15 15 15 15-6.729 15-15S23.271 0 15 0zm0 28.378c-3.675 0-7.008-1.49-9.428-3.896a13.45 13.45 0 0 1-2.426-3.285A13.295 13.295 0 0 1 1.622 15C1.622 7.623 7.623 1.622 15 1.622c3.499 0 6.688 1.35 9.074 3.557a13.45 13.45 0 0 1 2.996 4.054A13.298 13.298 0 0 1 28.378 15c0 7.377-6.001 13.378-13.378 13.378z">
                        </path>
                        <circle r="1.622" cy="11.655" cx="10.101"></circle>
                        <circle r="1.622" cy="11.655" cx="20.135"></circle>
                        <path d="M14.971 23.31c3.138 0 6.144-1.604 7.866-4.268l-1.362-.88a7.77 7.77 0 0 1-7.368 3.477 7.779 7.779 0 0 1-5.582-3.477l-1.362.88c1.5 2.32 4.026 3.893 6.758 4.208.35.04.701.06 1.05.06z">
                        </path>
                      </svg>
                    </div>
                  </div>

                  <!-- BOTTOM TOOLBAR -->

                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </aside>

    <main>
      <div class="zone-de-recherche">
        <input type="text" placeholder="Recherche Twitter">


        <div class="onglet">
          <nav>
            <ul>
              <li class="menu-courant"><a href="">A la une</a></li>
              <li><a href="">Récent</a></li>
              <li><a href="">Personnes</a></li>
              <li><a href="">Photos</a></li>
              <li><a href="">Vidéos</a></li>
            </ul>
          </nav>
        </div>
      </div>


      <ul>
        <li>


          <!-- debut d'un tweet -->
          <?php
          if (isset($_POST['etext'])) {
          }
          ?>

          <body>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "connexion");


            $sql = "SELECT messages.*, user.logname FROM messages 
            LEFT JOIN user ON messages.user_id = user.id ORDER BY messages.id DESC";



            $result = mysqli_query($conn, $sql);
            ?>

            <div class="tw-block-parent">
              <div class="timeline-TweetList-tweet">
                <?php
                require_once("AfficheDate.php");

                // Utilisation de la classe Database pour récupérer les messages
                $database = new Database("localhost", "root", "", "connexion");
                $messages = $database->getMessages();
                
                // Inversion de l'ordre des messages pour afficher les plus récents en premier
                $messages = array_reverse($messages);
                
                // Affichage des messages et de la date d'envoi pour chaque message
                foreach ($messages as $message) {
                  // ...
                
                
                ?>
                  <div class="timeline-Tweet">
                    <div class="timeline-Tweet-brand">
                      <div class="Icon Icon--twitter"></div>
                    </div>
                    <div class="timeline-Tweet-author">
                      <div class="TweetAuthor">
                        <a class="TweetAuthor-link" href="#channel"></a>
                        <span class="TweetAuthor-avatar">
                          <div class="Avatar"></div>
                        </span>
                        <span class="TweetAuthor-name">
                          <?php echo $message["logname"]; ?>
                        </span>
                        <span class="Icon Icon--verified"></span>
                        <span class="TweetAuthor-screenName">
                          @<?php echo $message["logname"]; ?>
                        </span>
                      </div>
                    </div>
                    <div class="timeline-Tweet-text">
                      <?php echo $message["message"]; ?>
                    </div>
                    <div class="timeline-Tweet-metadata">
                      <span class="timeline-Tweet-timestamp">
                        
                        <?php echo formatDate($message["date"]); ?>
                      </span>
                    </div>
                    <ul class="timeline-Tweet-actions">
                      <form method="POST">
                        <button type="submit" class="timeline-Tweet-action Icon Icon--heart" name="like" title="Like"></button>
                        <?php
                        require_once('Like.php');
                        ?>
                        <button type="submit" class="timeline-Tweet-action Icon Icon--delete" name="delete" title="Delete"></button>
                      </form>
                    </ul>
                  </div>
                <?php
                }
                ?>


                <!-- partial -->


                <script src="boutontweeter.js"></script>

                <!-- partial -->
                <script src='//cdnjs.cloudflare.com/ajax/libs/codemirror/5.22.0/codemirror.min.js'></script>
                <script src='//cdnjs.cloudflare.com/ajax/libs/preact/8.2.7/preact.min.js'></script>
                <script src='https://cdn.rawgit.com/a-mt/020212e6d9daec5ca0da69bef55bba01/raw/3f0913be305e44796313284ab2d4292e44790bff/emojiInfo.en.js'></script>
                <script src='https://codepen.io/a-mt/pen/VdoWRK.js'></script>
                <script src='//twemoji.maxcdn.com/2/twemoji.min.js?2.4'></script>
                <script src="pagescript.js"></script>



          </body>

</html>