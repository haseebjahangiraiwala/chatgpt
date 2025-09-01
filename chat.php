<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ChatGPT Clone Test</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f7fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .chat-container {
      width: 500px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }
    .chat-header {
      background: #10a37f;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
    }
    .chat-box {
      flex: 1;
      padding: 15px;
      overflow-y: auto;
      max-height: 400px;
    }
    .message {
      margin: 8px 0;
      padding: 12px;
      border-radius: 10px;
      line-height: 1.4;
      max-width: 80%;
      word-wrap: break-word;
    }
    .user-msg {
      background: #10a37f;
      color: white;
      align-self: flex-end;
    }
    .bot-msg {
      background: #e9ecef;
      color: #333;
      align-self: flex-start;
    }
    .chat-input {
      display: flex;
      border-top: 1px solid #ddd;
    }
    .chat-input input {
      flex: 1;
      padding: 12px;
      border: none;
      outline: none;
    }
    .chat-input button {
      background: #10a37f;
      color: white;
      border: none;
      padding: 12px 18px;
      cursor: pointer;
      transition: 0.3s;
    }
    .chat-input button:hover {
      background: #0c7d61;
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <div class="chat-header">ChatGPT Clone Test</div>
    <div class="chat-box" id="chatBox"></div>
    <div class="chat-input">
      <input type="text" id="userInput" placeholder="Type a message...">
      <button onclick="sendMessage()">Send</button>
    </div>
  </div>
 
  <script>
    function sendMessage() {
      let userInput = document.getElementById("userInput");
      let msg = userInput.value.trim();
      if (msg === "") return;
 
      let chatBox = document.getElementById("chatBox");
 
      let userDiv = document.createElement("div");
      userDiv.className = "message user-msg";
      userDiv.innerText = msg;
      chatBox.appendChild(userDiv);
 
      let botDiv = document.createElement("div");
      botDiv.className = "message bot-msg";
      botDiv.innerText = "Typing...";
      chatBox.appendChild(botDiv);
 
      chatBox.scrollTop = chatBox.scrollHeight;
 
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "process.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          botDiv.innerText = xhr.responseText;
          chatBox.scrollTop = chatBox.scrollHeight;
        }
      };
      xhr.send("message=" + encodeURIComponent(msg));
 
      userInput.value = "";
    }
  </script>
</body>
</html>
 
