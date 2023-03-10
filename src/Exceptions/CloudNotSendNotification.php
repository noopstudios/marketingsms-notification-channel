<?php

namespace NotificationChannels\MarketingSMS\Exceptions;

class CloudNotSendNotification extends \Exception
{
    public static function marketingSMSError(string $message, int $code): self
    {
        return new static(sprintf('MarketingSMS responded with error %d, message: %s', $code, $message), $code);
    }
}