<?php
$apiKey = "sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxx";   // yaha apni nayi Secret Key dalo
$projectId = "proj_xxxxxxxxxxxxxxxxxxxxxxx";   // yaha apna Project ID dalo
 
$userMessage = $_POST['message'] ?? '';
 
if (empty($userMessage)) {
    echo json_encode(["error" => "No message provided"]);
    exit;
}
 
$url = "https://api.openai.com/v1/chat/completions";
 
$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful AI assistant."],
        ["role" => "user", "content" => $userMessage]
    ]
];
 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey",
    "OpenAI-Project: $projectId"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
 
$response = curl_exec($ch);
curl_close($ch);
 
$result = json_decode($response, true);
 
if (isset($result['choices'][0]['message']['content'])) {
    echo json_encode([
        "reply" => $result['choices'][0]['message']['content']
    ]);
} else {
    echo json_encode([
        "error" => $result
    ]);
}
?>
