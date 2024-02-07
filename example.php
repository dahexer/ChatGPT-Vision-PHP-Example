<?php
// Here's the map to your treasure. Replace "Path to the image" with the actual path to your sacred image.
$imagePath = "Path to the image";

// Behold the alchemy! This spell encodes your image into a mystical base64 potion.
$base64Image = encodeImage($imagePath);

// A wise old function that whispers to your image and turns it into a base64-encoded spirit.
function encodeImage($imagePath): string {
    // This sorcery fetches your image's essence.
    $imageContent = file_get_contents($imagePath);
    // And this incantation transforms it into a base64 charm.
    return base64_encode($imageContent);
}

// Secret handshake for the digital spirits of OpenAI. Replace "Your OpenAI API key" with your actual key.
$apiKey = "Your OpenAI API key";

// Crafting the spell components to communicate with the API.
$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer {$apiKey}"
];

// The heart of the spell, where you ask the spirits for visions and poetry.
$payload = [
    'model'      => 'gpt-4-vision-preview', // The spirit you wish to summon.
    'messages'   => [ // Your message to the spirit.
        [
            'role'    => 'user', // You, the summoner.
            'content' => [
                [
                    'type' => 'text', // Your request, in words.
                    'text' => "What’s in this image? Write a short but detailed description."
                ],
                [
                    'type' => 'image_url', // Your offering, in image form.
                    'image_url' => "data:image/jpeg;base64,$base64Image"
                ],
            ],
        ]
    ],
    'max_tokens' => 200, // How much you're willing to let the spirit ramble.
];

// Opening the portal to the API.
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Speak, spirit!
$response = curl_exec($ch);
curl_close($ch);

// The spirits speak in riddles. This part tries to make sense of their words.
$responseData = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // When the spirits are just mumbling nonsense.
    echo json_encode(["error" => "Failed to decode JSON response"]);
    exit;
}

// Sharing the wisdom bestowed upon you by the digital spirits.
echo json_encode($responseData);
?>
