<?php

namespace NotificationChannels\MarketingSMS\Exceptions;

use Exception;

class InvalidPhoneNumber extends Exception {
    public static function configurationNotSet(): self
    {
        return new static(__('Invalid Phone Number'));
    }
}