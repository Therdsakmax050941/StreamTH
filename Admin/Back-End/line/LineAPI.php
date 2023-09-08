<?php
class LineAPI
{
    private $channelId;
    private $channelSecret;
    private $accessToken;
    private $apiEndpoint = 'https://api.line.me/v2/bot/message';

    public function __construct($channelId, $channelSecret, $accessToken)
    {
        $this->channelId = $channelId;
        $this->channelSecret = $channelSecret;
        $this->accessToken = $accessToken;
    }

    public function sendTextMessage($userId, $message)
    {
        $url = $this->apiEndpoint . '/push';
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken
        ];
        $data = [
            'to' => $userId,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message
                ]
            ]
        ];

        $this->sendRequest($url, $headers, $data);
    }

    private function sendRequest($url, $headers, $data)
    {
        $options = [
            'http' => [
                'header' => $headers,
                'method' => 'POST',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }
}