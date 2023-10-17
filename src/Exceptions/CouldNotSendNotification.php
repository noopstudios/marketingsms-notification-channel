<?php

namespace NotificationChannels\MarketingSMS\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    public static function marketingSMSError(string $message, int $code): self
    {
        return new static(sprintf('MarketingSMS responded with error %d, message: %s', $code, $message), $code);
    }

    public static function invalidReceiver(): self
    {
        return new static(__('The notifiable did not have a receiving phone number. Add a routeNotificationForMarketingSMS
            method or a phone_number attribute to your notifiable.'));
    }
}