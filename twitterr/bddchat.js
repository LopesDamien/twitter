// Connexion à la base de données de chat
var conn = new WebSocket('ws://localhost:8080');

// Traitement des messages entrants
conn.onmessage = function (event) {
  var data = JSON.parse(event.data);
  var messageList = document.getElementById('message-list');
  var messageItem = document.createElement('li');
  messageItem.innerText = data.message;
  messageList.appendChild(messageItem);
};

// Traitement du formulaire de message
var form = document.getElementById('message-form');
form.addEventListener('submit', function (event) {
  event.preventDefault();
  var messageInput = document.getElementById('message-input');
  var message = messageInput.value;
  conn.send(message);
  messageInput.value = '';
});
