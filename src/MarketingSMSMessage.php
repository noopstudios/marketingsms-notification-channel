<?php

namespace Noopstudios\MarketingSMS;

class MarketingSMSMessage
{
    /**
     * The message name.
     *
     * @var string
     */
    protected $name;

    /**
     * The message content.
     *
     * @var string
     */
    protected $message;

    /**
     * The sender of the message.
     *
     * @var string
     */
    protected $from;


    /**
     * When the message will be delivered.
     * @var string
     */
    protected $deliveredAt;

    /**
     * Json array with the message destinations.
     *
     * @var string
     */
    protected $phones;

    /**
     * @param $name
     * @param $message
     * @param $from
     * @param $deliveredAt
     * @param $phones
     */
    public function __construct(array $messageDetails)
    {
        $this->name = $messageDetails['name'];
        $this->message = $messageDetails['message'];
        $this->from = $messageDetails['from'];
        $this->deliveredAt = $messageDetails['deliveredAt'];
        $this->phones = $messageDetails['phones'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getDeliveredAt()
    {
        return $this->deliveredAt;
    }

    /**
     * @return string
     */
    public function getPhones()
    {
        return $this->phones;
    }
}