<?php

namespace NotificationChannels\MarketingSMS\Test;

use NotificationChannels\MarketingSMS\Test\TestCase;
use Noopstudios\MarketingSMS\MarketingSMSMessage;

class MarketingSMSMessageTest extends TestCase
{
    /** @var MarketingSMSMessage */
    protected $message;

    public function setUp(): void
    {
        parent::setUp();
        $messageDetails = [
            'name' => 'Name',
            'message' => 'message',
            'from' => '00351968098228',
            'deliveredAt' => null,
            'phones' => '["00351968098228"]'
        ];
        $this->message = new MarketingSMSMessage($messageDetails);
    }

    public function test_it_can_get_the_content()
    {
        $this->assertEquals('message', $this->message->getMessage());
    }
}