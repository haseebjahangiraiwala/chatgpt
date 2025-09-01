<?php
// Database include (agar tum database use karna chahte ho)
include("db.php");
 
// User message frontend se aayega
$user_msg = $_POST['message'] ?? '';
 
if (empty($user_msg)) {
    echo json_encode(["error" => "No message provided"]);
    exit;
}
 
/* 
👉 Yahan apni REAL API KEY aur PROJECT ID dalni hai
    - API Key (starts with sk-proj-)
    - Project ID (starts with proj_)
*/
$apiKey   = "sk-proj-XXXXXXXXXXXXXXXXXXXXXXXXXXXX"; 
$projectId = "proj_XXXXXXXXXXXXXXXXXXXXXXXX";       
 
// Data OpenAI ko bhejna
$data = [
    "model" => "gpt-4o-mini",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => $user_msg]
    ]
];
 
// CURL request OpenAI API ko bhejne ke liye
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey",
    "OpenAI-Project: $projectId"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
 
$response = curl_exec($ch);
 
if (curl_errno($ch)) {
    echo "CURL Error: " . curl_error($ch);
    exit;
}
curl_close($ch);
 
$res = json_decode($response, true);
 
// Bot ka reply extract karna
if (isset($res["choices"][0]["message"]["content"])) {
    $bot_msg = trim($res["choices"][0]["message"]["content"]);
} else {
    echo "API Error: " . $response;
    exit;
}
 
// Agar DB use kar rahe ho to chats table me save hoga
if (isset($conn)) {
    $stmt = $conn->prepare("INSERT INTO chats (user_msg, bot_msg) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_msg, $bot_msg);
    $stmt->execute();
}
 
// Bot ka reply frontend ko bhejna
echo $bot_msg;
?>
 
