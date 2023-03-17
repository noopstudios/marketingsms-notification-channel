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

    public function send($notifiable, Notification $notification): void
    {
        $phones = $notifiable->routeNotificationFor('marketingSMS');

        if (!$phones) {
            $phones = $notifiable->routeNotificationFor(MarketingSMSChannel::class);
        }

        if (!$phones) {
            return;
        }

        $message = $notification->toMarketingSMS($notifiable);

        if(is_string($message)){
            $message = new MarketingSMSMessage($message);
        }

        if(! $message instanceof MarketingSMSMessage){
            return;
        }

        $response = $this->client->sendMessage([
            'name' => $message->name,
            'message' => $message->message,
            'from' => $message->from ?? config('marketing_sms.from'),
            'delivered_at' => $message->deliveredAt ?? null,
            'phones' => $message->phones,
        ]);

        $response = $this->client->sendMessage($message);
        if ($response->getResponseCode() != 200) {
            throw Exceptions\CloudNotSendNotification::marketingSMSError($response->getCleanResponse(), $response->getResponseCode());
        }
    }
}