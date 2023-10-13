<?php

namespace NotificationChannels\MarketingSMS\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet(): self
    {
        return new static('To send notifications via MarketingSMS you need credentials.');
    }
}
