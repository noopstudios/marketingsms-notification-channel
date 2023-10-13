<?php

namespace Noopstudios\MarketingSMS\Test;

use Illuminate\Notifications\Notification;
use Noopstudios\MarketingSMS\marketingSMS;
use Noopstudios\MarketingSMS\MarketingSMSChannel;
use Noopstudios\MarketingSMS\MarketingSMSMessage;
use NotificationChannels\MarketingSMS\Exceptions\CouldNotSendNotification;
use NotificationChannels\MarketingSMS\Test\TestCase;
use Mockery;

class MarketingSMSChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $client;

    /** @var \Noopstudios\MarketingSMS\MarketingSMSChannel */
    protected $channel;

    public function setUp(): void
    {
        parent::setUp();
        $this->marketingSMS = Mockery::mock(marketingSMS::class);
        $this->channel = new MarketingSMSChannel($this->marketingSMS);
    }

    public function test_can_be_instatiated()
    {
        $this->assertInstanceOf(marketingSMS::class, $this->marketingSMS);
        $this->assertInstanceOf(MarketingSMSChannel::class, $this->channel);
    }

    public function test_can_send_sms_notification_to_notifiable_with_method()
    {
        $this->marketingSMS->expects('sendMessage')
            ->once()
            ->andReturn([
                'data' => [
                    'id' => 11,
                    'number_credits_delivery' => 1,
                    'number_sms_delivery' => 1,
                    'available_credits' => 10,
                ],
                'success' => 200
            ]);

        $this->channel->send(new NotifiableWithMethod, new TestNotification);
    }
}


class NotifiableWithMethod
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return string
     */
    public function routeNotificationForMarketingSMS()
    {
        return '00351913909730';
    }
}

class TestNotification extends Notification
{

    protected $name = 'Name';
    protected $message = 'Message';
    protected $from = 'From';
    protected $deliveredAt = null;
    protected $phones = "[\"00351913909730\"]";

    /**
     * @param $notifiable
     * @return MarketingSMSMessage
     *
     * @throws CouldNotSendNotification
     */
    public function toMarketingSMS($notifiable)
    {
        return new MarketingSMSMessage([
            'name' => $this->name,
            'message' => $this->message,
            'from' => $this->from,
            'deliveredAt' => $this->deliveredAt,
            'phones' => $this->phones
        ]);
    }
}

class TestNotificationWithGetTo extends Notification
{
    /**
     * @param $notifiable
     * @return MarketingSMSMessage
     *
     * @throws CouldNotSendNotification
     */
    public function toMarketingSMS($notifiable)
    {
        return (new MarketingSMSMessage())
            ->to('00351913909730');
    }
}

class Notifiable
{
    public $phones = null;

    public function routeNotificationFor()
    {
    }
}

class NotifiableWithAttribute
{
    public $phones = "[\"00351913909730\"]";

    public function routeNotificationFor()
    {
    }
}