<?php

namespace NotificationChannels\MarketingSMS;

use Illuminate\Notifications\Notification;
use NotificationChannels\MarketingSMS\Exceptions\InvalidConfiguration;
use NotificationChannels\MarketingSMS\Exceptions\CouldNotSendNotification;
use Noopstudios\MarketingSMS\marketingSMS;
use NotificationsChannels\MarketingSMS\Exceptions\InvalidPhoneNumber;

class MarketingSMSChannel
{
    private $client;

    public function __construct(marketingSMS $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification): void
    {
        $message = $notification->toMarketingSMS($notifiable);

        $phones = $this->getTo($notifiable, $notification, $message);

        if (empty($phones)) {
            throw InvalidPhoneNumber::configurationNotSet();
        }

        $message = $notification->toMarketingSMS($notifiable);

        if(is_array($message)){
            $message = new MarketingSMSMessage($message);
        }

        if(! $message instanceof MarketingSMSMessage){
            throw InvalidConfiguration::configurationNotSet();
        }

        $response = $this->client->sendMessage([
            'name' => $message->getName(),
            'message' => $message->getMessage(),
            'from' => $message->getFrom() ?? config('marketing_sms.from'),
            'delivered_at' => $message->getDeliveredAt() ?? null,
            'phones' => $message->getPhones(),
        ]);

        if ($response['success'] != 200) {
            throw CouldNotSendNotification::marketingSMSError($response->getCleanResponse(), $response->getResponseCode());
        }
    }

    private function getTo($notifiable, Notification $notification, MarketingSMSMessage $message)
    {
        if (! empty($message->getPhones())) {
            return $message->getPhones();
        }

        if ($notifiable->routeNotificationFor(static::class, $notification)) {
            return $notifiable->routeNotificationFor(static::class, $notification);
        }

        if ($notifiable->routeNotificationFor('marketingsms', $notification)) {
            return $notifiable->routeNotificationFor('marketingsms', $notification);
        }

        if (isset($notifiable->phones)) {
            return $notifiable->phones;
        }

        throw CouldNotSendNotification::invalidReceiver();
    }
}