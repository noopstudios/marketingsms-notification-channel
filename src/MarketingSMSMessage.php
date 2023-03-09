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
    public function __construct($name, $message, $from, $deliveredAt, $phones)
    {
        $this->name = $name;
        $this->message = $message;
        $this->from = $from;
        $this->deliveredAt = $deliveredAt;
        $this->phones = $phones;
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
     * @param string $deliveredAt
     */
    public function setDeliveredAt($deliveredAt)
    {
        $this->deliveredAt = $deliveredAt;
    }

    /**
     * @return string
     */
    public function getPhones()
    {
        return $this->phones;
    }
}