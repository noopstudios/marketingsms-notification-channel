<?php

namespace Noopstudios\MarketingSMS;

use Illuminate\Notifications\Notification;
use NotificationChannels\MarketingSMS\Exceptions;
use Noopstudios\MarketingSMS\marketingSMS;

class MarketingSMSChannel
{
    private $client;

    public function __construct(marketingSMS $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMarketingSMS($notifiable);
        $response = $this->client->sendMessage($message);
        if ($response->getStatusCode() != 200) {
            throw Exceptions\CloudNotSendNotification::marketingSMSError($response->getCleanResponse(), $response->getResponseCode());
        }
    }
}